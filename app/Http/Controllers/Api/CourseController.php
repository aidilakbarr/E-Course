<?php

namespace App\Http\Controllers\Api;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\UserResource;
use App\Models\Course;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $courses = Course::with('instructor')
            ->filterByUser(auth()->user())
            ->search($request->query('search'))
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return response()->json([
            'success' => true,
            'message' => 'Daftar course ditemukan',
            'pagination' => [
                'current_page' => $courses->currentPage(),
                'last_page' => $courses->lastPage(),
                'per_page' => $courses->perPage(),
                'total' => $courses->total(),
                'prev_page_url' => $courses->previousPageUrl(),
                'next_page_url' => $courses->nextPageUrl(),
            ],
            'data' => CourseResource::collection($courses),
            'user' => new UserResource($user),
        ], 200);
    }

    public function store(StoreCourseRequest $request, Course $course)
    {
        try {
            $validated = $request->validated();

            if ($request->hasFile('thumbnail')) {
                $validated['thumbnail'] = FileUploadService::uploadThumbnail(
                    $request->file('thumbnail'),
                    $course->thumbnail
                );
            }

            $user = auth()->user();
            if ($user->role !== RoleEnum::ADMIN) {
                $validated['instructor_id'] = $user->id;
            }


            $course = Course::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Course berhasil disimpan',
                'form' => $validated,
                'data' => new CourseResource($course),
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan course',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Course $course)
    {
        $course->load('instructor');
        return response()->json([
            'success' => true,
            'data' => new CourseResource($course),
        ]);
    }

    public function update(StoreCourseRequest $request, Course $course)
    {
        $validated = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = FileUploadService::uploadThumbnail(
                $request->file('thumbnail'),
                $course->thumbnail
            );
        }

        $course->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Course berhasil diperbarui',
            'data' => new CourseResource($course),
        ]);
    }


    public function destroy(Course $course)
    {
        try {
            $user = auth()->user();
            if (
                $user->role !== RoleEnum::ADMIN &&
                ($user->role !== RoleEnum::INSTRUCTOR || $course->instructor_id !== $user->id)
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak punya akses untuk menghapus course ini'
                ], 403);
            }

            if ($course->thumbnail) {
                FileUploadService::deleteFile($course->thumbnail);
            }

            $course->delete();

            return response()->json([
                'success' => true,
                'message' => "Course berhasil dihapus"
            ]);
        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus course',
                'error' => $e->getMessage(),
            ], 500);
        }

    }

    public function Filtering(Request $request)
    {
        $courses = Course::filter($request->only(['instructor_id', 'role', 'status']))->paginate(5);
        return CourseResource::collection($courses)
            ->additional([
                'success' => true,
                'message' => 'Daftar course ditemukan',
            ]);
    }
}

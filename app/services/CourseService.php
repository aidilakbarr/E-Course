<?php

namespace App\Services;

use App\Enums\RoleEnum;
use App\Models\Course;
use App\Repositories\CourseRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use App\Services\FileUploadService;

class CourseService
{
    public function __construct(protected CourseRepository $repository)
    {
    }

    public function store(array $validated, ?UploadedFile $thumbnail = null): Course
    {
        if ($thumbnail) {
            $validated['thumbnail'] = FileUploadService::uploadThumbnail($thumbnail);
        }

        $user = Auth::user();
        if ($user->role !== RoleEnum::ADMIN) {
            $validated['instructor_id'] = $user->id;
        }

        return $this->repository->store($validated);
    }

    public function update(Course $course, array $validated, ?UploadedFile $thumbnail = null): Course
    {
        if ($thumbnail) {
            $validated['thumbnail'] = FileUploadService::uploadThumbnail($thumbnail, $course->thumbnail);
        }

        return $this->repository->update($course, $validated);
    }

    public function delete(Course $course): void
    {
        if ($course->thumbnail) {
            FileUploadService::deleteFile($course->thumbnail);
        }

        $this->repository->destroy($course);
    }
}

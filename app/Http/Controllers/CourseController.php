<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\RoleEnum;
use App\Http\Requests\StoreCourseRequest;
use App\Models\Course;
use App\Models\User;

class CourseController extends Controller
{


    public function index(Request $request)
    {
        $query = Course::query();

        // Filter berdasarkan role
        if (auth()->user()->role !== RoleEnum::ADMIN) {
            $query->where('instructor_id', auth()->id());
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhereHas('instructor', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        // Ambil data dengan paginasi + query string (untuk mempertahankan ?search=xxx saat pindah halaman)
        $courses = $query->latest()->paginate(10)->withQueryString();

        return view('admin.courses.index', compact('courses'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $instructors = User::where('role', RoleEnum::INSTRUCTOR)->get();
        return view('admin.courses.create', compact('instructors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {

        $data = $request->validated();
        if (empty($data['instructor_id'])) {
            $data['instructor_id'] = auth()->id();
        }

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $data['thumbnail'] = $path;
        }

        Course::create($data);

        return redirect()->route('courses.index')->with('success', 'Course berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $instructors = User::where('role', RoleEnum::INSTRUCTOR)->get();
        return view('admin.courses.edit', compact('course', 'instructors'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCourseRequest $request, Course $course)
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $data['thumbnail'] = $path;
        }

        $course->update($data); // cukup update satu entri

        return redirect()->route('courses.index')->with('success', 'Course berhasil diedit');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        try {
            $course->delete();
            return redirect()->route('courses.index')->with('Success', 'course berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('Error', 'Gagal menghapus course.');
        }
    }
}

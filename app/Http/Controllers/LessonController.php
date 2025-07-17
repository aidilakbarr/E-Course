<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLessonRequest;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request, Course $course)
    {
        $query = $course->lessons(); // relasi one-to-many

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('video_url', 'like', "%{$search}%")
                    ->orWhere('order', 'like', "%{$search}%");
            });
        }

        $lessons = $query->orderBy('order')->paginate(10)->withQueryString();

        return view('admin.lessons.index', compact('course', 'lessons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        return view('admin.lessons.create', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonRequest $request, Course $course)
    {
        $validated = $request->validated();
        $validated['course_id'] = $course->id;

        Lesson::create($validated);

        return redirect()->route('courses.lessons.index', $course)->with('success', 'Lesson berhasil ditambahkan.');
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
    public function edit(Course $course, Lesson $lesson)
    {
        return view('admin.lessons.edit', compact('course', 'lesson'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreLessonRequest $request, Course $course, Lesson $lesson)
    {
        $validated = $request->validated();
        $validated['course_id'] = $course->id;

        $lesson->update($validated);

        return redirect()->route('courses.lessons.index', $course)
            ->with('success', 'Lesson berhasil diedit.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('courses.lessons.index', $course)->with('success', 'Lesson berhasil dihapus');
    }
}

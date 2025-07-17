<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssignmentRequest;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Course $course, Lesson $lesson)
    {
        $query = $lesson->assignments();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('due_date', 'like', "%{$search}%");
            });
        }

        $assignments = $query->latest()->paginate(10)->withQueryString();

        return view('admin.assignments.index', compact('course', 'lesson', 'assignments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course, Lesson $lesson)
    {
        return view('admin.assignments.create', compact('course', 'lesson'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssignmentRequest $request, Course $course, Lesson $lesson)
    {
        $validated = $request->validated();
        $validated['lesson_id'] = $lesson->id;

        Assignment::create($validated);

        return redirect()->route('courses.lessons.assignments.index', [$course, $lesson])->with('success', 'Assignment berhasil ditambahkan.');

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
    public function edit(Course $course, Lesson $lesson, Assignment $assignment)
    {
        return view('admin.assignments.edit', compact('course', 'lesson', 'assignment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAssignmentRequest $request, Course $course, Lesson $lesson, Assignment $assignment)
    {
        $validated = $request->validated();
        $validated['lesson_id'] = $lesson->id;

        $assignment->update($validated);

        return redirect()->route('courses.lessons.assignments.index', [$course, $lesson])
            ->with('success', 'Assignment berhasil diedit.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Lesson $lesson, Assignment $assignment)
    {
        $lesson->delete();
        return redirect()->route('courses.lessons.index', [$course, $assignment])->with('success', 'Assignment berhasil dihapus');
    }
}

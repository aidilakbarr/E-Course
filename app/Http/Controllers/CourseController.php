<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Models\Course;

class CourseController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $courses = Course::all();
        // dd($courses);
        return view('admin.course.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.course.create');
    }

    /**
     * Store a newly created resource in storage.
     */public function store(StoreCourseRequest $request)
{
    $data = $request->validated(); 

    if ($request->hasFile('thumbnail')) {
        $path = $request->file('thumbnail')->store('thumbnails', 'public');
        $data['thumbnail'] = $path;
    }

    Course::create($data); 

    return redirect()->route('course.index')->with('success', 'Course berhasil ditambahkan');
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
        return view('admin.course.edit', compact('course'));
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

    return redirect()->route('course.index')->with('success', 'Course berhasil diedit');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        try {
            $course->delete();
            return redirect()->route('course.index')->with('Success', 'course berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('Error', 'Gagal menghapus course.');
        }
    }
}

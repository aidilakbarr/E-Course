@extends('layouts.app')
@section('title', 'Add Lesson')

@section('content')
    <main class="w-full flex-grow p-6">
        <h1 class="w-full text-3xl text-black pb-6">Add Assignment</h1>

        <div class="flex flex-wrap">
            <div class="w-full lg:w-2/3 xl:w-1/2">
                <form method="POST" action="{{ route('courses.lessons.assignments.store', [$course, $lesson]) }}"
                    class="p-8 bg-white rounded-lg shadow-md">
                    @csrf
                    <input type="hidden" name="lesson_id" value="{{ $course->id }}">


                    <div class="mb-4">
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">
                            Assignment Title
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}"
                            class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded
                               focus:outline-none focus:ring-2 focus:ring-[#3d68ff]"
                            placeholder="Enter lesson title" required>
                        @error('title')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">
                            Assignment Description
                        </label>
                        <input type="text" name="description" id="description" value="{{ old('description') }}"
                            class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded
                               focus:outline-none focus:ring-2 focus:ring-[#3d68ff]"
                            placeholder="..." required>
                        @error('description')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="due_date" class="block text-sm font-semibold text-gray-700 mb-1">
                            Due Date
                        </label>
                        <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}"
                            class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded
                               focus:outline-none focus:ring-2 focus:ring-[#3d68ff]"
                            placeholder="https://example.com/video.mp4" required>
                        @error('due_date')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="text-right">
                        <button type="submit"
                            class="bg-[#3d68ff] hover:bg-[#2d56d9] text-white font-semibold px-6 py-2 rounded-lg shadow-md transition duration-200">
                            <i class="fas fa-save mr-2"></i> Upload Assignment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection

@extends('layouts.app')
@section('title', 'Add Lesson')

@section('content')
    <main class="w-full flex-grow p-6">
        <h1 class="w-full text-3xl text-black pb-6">Add Lesson</h1>

        <div class="flex flex-wrap">
            <div class="w-full lg:w-2/3 xl:w-1/2">
                <form method="POST" action="{{ route('courses.lessons.store', $course) }}"
                    class="p-8 bg-white rounded-lg shadow-md">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">


                    {{-- Title --}}
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">
                            Lesson Title
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}"
                            class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded
                               focus:outline-none focus:ring-2 focus:ring-[#3d68ff]"
                            placeholder="Enter lesson title" required>
                        @error('title')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Order --}}
                    <div class="mb-4">
                        <label for="order" class="block text-sm font-semibold text-gray-700 mb-1">
                            Lesson Order
                        </label>
                        <input type="number" name="order" id="order" value="{{ old('order') }}"
                            class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded
                               focus:outline-none focus:ring-2 focus:ring-[#3d68ff]"
                            placeholder="e.g. 1, 2, 3..." required>
                        @error('order')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Content --}}
                    <div class="mb-4">
                        <label for="order" class="block text-sm font-semibold text-gray-700 mb-1">
                            Content
                        </label>
                        <input type="text" name="content" id="content" value="{{ old('content') }}"
                            class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded
                               focus:outline-none focus:ring-2 focus:ring-[#3d68ff]"
                            placeholder="..." required>
                        @error('content')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Video --}}
                    <div class="mb-6">
                        <label for="video_url" class="block text-sm font-semibold text-gray-700 mb-1">
                            Video URL
                        </label>
                        <input type="url" name="video_url" id="video_url" value="{{ old('video_url') }}"
                            class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded
                               focus:outline-none focus:ring-2 focus:ring-[#3d68ff]"
                            placeholder="https://example.com/video.mp4" required>
                        @error('video_url')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="text-right">
                        <button type="submit"
                            class="bg-[#3d68ff] hover:bg-[#2d56d9] text-white font-semibold px-6 py-2 rounded-lg shadow-md transition duration-200">
                            <i class="fas fa-save mr-2"></i> Save Lesson
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection

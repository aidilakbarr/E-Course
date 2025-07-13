@extends('layouts.app')
@section('title', 'Table')

@section('content')
    <main class="w-full flex-grow p-6">
        <h1 class="w-full text-3xl text-black pb-6">Forms</h1>

        <div class="flex flex-wrap">
            <div class="w-full lg:w-1/2 my-6 pr-0 lg:pr-2">
                <p class="text-xl pb-6 flex items-center">
                    <i class="fas fa-list mr-3"></i> edit Course
                </p>
                <div class="leading-loose">
                    <form class="p-10 bg-white rounded shadow-xl" method="POST" action="{{ route('course.update', $course) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Thumbnail --}}
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600" for="thumbnail">Thumbnail</label>
                            <input type="file" name="thumbnail" id="thumbnail"
                                class="w-full px-5 py-2 bg-gray-200 rounded">
                            @error('thumbnail')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Title --}}
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600" for="title">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $course->title) }}"
                                class="w-full px-5 py-2 bg-gray-200 rounded" required>
                            @error('title')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600" for="description">Description</label>
                            <textarea name="description" id="description" class="w-full px-5 py-2 bg-gray-200 rounded"
                                placeholder="Course Description">{{ old('description', $course->description) }}</textarea>
                            @error('description')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Teacher --}}
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600" for="teacher">Teacher</label>
                            <input type="text" name="teacher" id="teacher"
                                value="{{ old('teacher', $course->Teacher) }}" class="w-full px-5 py-2 bg-gray-200 rounded"
                                placeholder="Course Teacher">
                            @error('teacher')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Start Date --}}
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600" for="start_on">Start Date</label>
                            <input type="date" name="start_on" id="start_on"
                                value="{{ old('start_on', \Carbon\Carbon::parse($course->start_on)->format('Y-m-d')) }}"
                                class="w-full px-5 py-2 bg-gray-200 rounded" required>
                            @error('start_on')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- End Date --}}
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600" for="ends_on">End Date</label>
                            <input type="date" name="ends_on" id="ends_on"
                                value="{{ old('ends_on', \Carbon\Carbon::parse($course->ends_on)->format('Y-m-d')) }}"
                                class="w-full px-5 py-2 bg-gray-200 rounded" required>
                            @error('ends_on')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kuota --}}
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600" for="kuota">Kuota</label>
                            <input type="number" name="kuota" id="kuota" value="{{ old('kuota', $course->kuota) }}"
                                class="w-full px-5 py-2 bg-gray-200 rounded" required>
                            @error('kuota')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600" for="status">Status</label>
                            <select name="status" id="status" class="w-full px-5 py-2 bg-gray-200 rounded" required>
                                @foreach (\App\Enums\StatusCourseEnum::cases() as $status)
                                    <option value="{{ $status->value }}"
                                        {{ old('status', $course->status) === $status->value ? 'selected' : '' }}>
                                        {{ $status->value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="mt-6">
                            <button type="submit"
                                class="px-4 py-2 text-white font-semibold bg-[#3d68ff] hover:bg-[#2d56d9] rounded">
                                Update Course
                            </button>
                        </div>
                    </form>



                </div>
            </div>
        </div>
    </main>
@endsection

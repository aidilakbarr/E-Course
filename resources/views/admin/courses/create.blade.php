@extends('layouts.app')
@section('title', 'Table')

@section('content')
    <main class="w-full flex-grow p-6">
        <h1 class="w-full text-3xl text-black pb-6">Forms</h1>

        <div class="flex flex-wrap">
            <div class="w-full lg:w-1/2 my-6 pr-0 lg:pr-2">
                <p class="text-xl pb-6 flex items-center">
                    <i class="fas fa-list mr-3"></i> Add Course
                </p>
                <div class="leading-loose">
                    <form class="p-10 bg-white rounded shadow-xl" method="POST" action="{{ route('courses.store') }}"
                        enctype="multipart/form-data">
                        @csrf

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
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                class="w-full px-5 py-2 bg-gray-200 rounded" required placeholder="Course Title">
                            @error('title')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600" for="description">Description</label>
                            <textarea name="description" id="description" class="w-full px-5 py-2 bg-gray-200 rounded"
                                placeholder="Course Description">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Teacher --}}
                        @if (auth()->user()->role === \App\Enums\RoleEnum::ADMIN)
                            <div class="mb-4">
                                <label class="block text-sm text-gray-600" for="description">Instructor</label>
                                <select name="instructor_id" id="instructor_id" class="w-full px-5 py-2 bg-gray-200 rounded"
                                    required>
                                    @foreach ($instructors as $instructor)
                                        <option value="{{ $instructor->id }}"
                                            {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                            {{ $instructor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('instructor')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        {{-- Status --}}
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600" for="status">Status</label>
                            <select name="status" id="status" class="w-full px-5 py-2 bg-gray-200 rounded" required>
                                @foreach (\App\Enums\StatusCourseEnum::cases() as $status)
                                    <option value="{{ $status->value }}"
                                        {{ old('status') === $status->value ? 'selected' : '' }}>
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
                                Submit
                            </button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </main>
@endsection

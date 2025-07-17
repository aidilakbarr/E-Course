@extends('layouts.app')
@section('title', 'Lessons')

@section('content')
    <main class="w-full flex-grow p-6">
        <h1 class="text-3xl text-black pb-4">Lessons</h1>

        <div class="w-full mb-6">
            <p class="text-xl pb-3 flex items-center">
                <i class="fas fa-book mr-3"></i> Lessons for: <strong class="ml-1">{{ $course->title }}</strong>
            </p>
            <div class="flex justify-between">


                <a href="{{ route('courses.enrollments.index', [$course]) }}" class="text-indigo-600 hover:underline">Lihat
                    Enrollments</a>

            </div>

            <div class="w-full overflow-x-auto">
                <div class="flex justify-between  my-4">
                    <a href="{{ route('courses.lessons.create', $course) }}">
                        <button
                            class="bg-[#3d68ff] font-semibold py-2 mt-3 mb-6 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-[#3a4e94] flex items-center justify-center px-6 text-white cursor-pointer">
                            <i class="fas fa-plus mr-3 text-white"></i> New Lesson
                        </button>
                    </a>

                    <form method="GET" action="{{ route('courses.lessons.index', $course) }}" class="mb-4 flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari judul/video/order..." class="border px-4 py-2 rounded" />
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Cari
                        </button>
                    </form>
                </div>
                <table class="min-w-[900px] table-fixed w-full border-collapse bg-white rounded-lg shadow">
                    <thead class="bg-gray-100">
                        <tr class="text-xs font-semibold text-gray-600 uppercase text-center">
                            <th class="w-[10%] px-4 py-2 whitespace-nowrap">#</th>
                            <th class="w-[30%] px-4 py-2 whitespace-nowrap">Title</th>
                            <th class="w-[30%] px-4 py-2 whitespace-nowrap">Order</th>
                            <th class="w-[30%] px-4 py-2 whitespace-nowrap">video</th>
                            <th class="w-[30%] px-4 py-2 whitespace-nowrap">assignment</th>
                            <th class="w-[30%] px-4 py-2 whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lessons as $lesson)
                            <tr x-data="{ open: false }" class="bg-white border-b border-gray-200 text-sm text-gray-900">
                                <td class="px-4 py-2 text-center">
                                    {{ $loop->iteration }}.
                                </td>
                                <td class="px-4 py-2 text-center font-medium">
                                    {{ $lesson->title }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    {{ $lesson->order }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    {{ $lesson->video_url }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('courses.lessons.assignments.index', [$course, $lesson]) }}">
                                        <button
                                            class="bg-green-400 hover:bg-green-500 text-white px-4 py-1 rounded-md shadow cursor-pointer">
                                            <i class="fas fa-edit"></i> Lihat
                                        </button>
                                    </a>
                                </td>
                                <td class="px-4 py-2 text-center space-x-2">
                                    <a href="{{ route('courses.lessons.edit', [$course, $lesson]) }}">
                                        <button
                                            class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-1 rounded-md shadow cursor-pointer">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                    </a>

                                    <button @click="open = true"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded-md shadow cursor-pointer">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>

                                    @include('partials.delete-modalbox', [
                                        'title' => 'Delete Lesson',
                                        'message' =>
                                            'Are you sure you want to delete lesson "' . $lesson->title . '"?',
                                        'route' => route('courses.lessons.destroy', [$course, $lesson]),
                                    ])
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-5 text-center text-gray-500">
                                    No lessons found for this course.
                                </td>
                            </tr>
                        @endforelse
                        <div class="mt-4">
                            {{ $lessons->links() }}
                        </div>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection

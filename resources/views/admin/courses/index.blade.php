@extends('layouts.app')
@section('title', 'Course')

@section('content')
    <main class="w-full flex-grow p-6">
        <h1 class="text-3xl text-black pb-4">Course</h1>
        <div class="w-full">
            <p class="text-xl pb-3 flex items-center">
                <i class="fas fa-list mr-3"></i> Table Course
            </p>
            <div class="w-full overflow-x-auto">
                <div class="flex justify-between  my-4">
                    <a href="courses/create">
                        <button
                            class="bg-[#3d68ff] font-semibold py-2 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-[#3a4e94] flex items-center justify-center px-6 text-white cursor-pointer">
                            <i class="fas fa-plus mr-3 text-white"></i> New Course
                        </button>
                    </a>

                    <form method="GET" action="{{ route('courses.index') }}" class="mb-4">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari course berdasarkan judul, deskripsi, atau instruktur"
                            class="border px-4 py-2 rounded" />
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded ml-2 hover:bg-blue-700">
                            Cari
                        </button>
                    </form>
                </div>


                <table class="min-w-[900px] table-fixed w-full border-collapse bg-white rounded-lg shadow">
                    <thead class="bg-gray-100">
                        <tr class="text-xs font-semibold text-gray-600 uppercase text-center">
                            <th class="w-[12.5%] px-4 py-2 whitespace-nowrap text-center">Thumbnail</th>
                            <th class="w-[12.5%] px-4 py-2 whitespace-nowrap text-center">Title</th>
                            @if (auth()->user()->role === \App\Enums\RoleEnum::ADMIN)
                                <th class="w-[12.5%] px-4 py-2 whitespace-nowrap text-center">Instructor</th>
                                <th class="w-[12.5%] px-4 py-2 whitespace-normal text-center">Description</th>
                            @endif
                            <th class="w-[12.5%] px-4 py-2 whitespace-nowrap text-center">Lesson</th>
                            <th class="w-[12.5%] px-4 py-2 whitespace-nowrap text-center">Status</th>
                            <th class="w-[12.5%] px-4 py-2 whitespace-nowrap text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>
                        @if ($courses->isEmpty())
                            <td colspan="8" class="px-5 py-5 border-b bg-white border-gray-200  text-sm w-full">
                                <div class="text-center w-full ">
                                    Tidak ada data
                                </div>
                            </td>
                        @else
                            @foreach ($courses as $course)
                                <tr x-data="{ open: false }" class="bg-white border-b border-gray-200 text-sm text-gray-900">
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{-- {{ dd($course->thumbnail) }} --}}

                                        <img src="{{ $course->thumbnail_url }}" alt="Course Thumbnail"
                                            class="w-32 h-32 object-cover rounded-md" />

                                    </td>


                                    <td class="px-4 py-2 text-center whitespace-nowrap font-medium">
                                        {{ $course->title }}
                                    </td>


                                    @if (auth()->user()->role === \App\Enums\RoleEnum::ADMIN)
                                        <td class="px-4 py-2 whitespace-normal max-w-[250px]">
                                            {{ Str::limit($course->description, 100) }}
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $course->instructor->name ?? '' }}
                                        </td>
                                    @endif
                                    <td class="px-4 py-2 text-center whitespace-nowrap">
                                        <a href="{{ route('courses.lessons.index', $course) }}"
                                            class="text-indigo-600 hover:underline">Lihat Lessons</a>
                                    </td>

                                    <td class="px-4 py-2 text-center whitespace-nowrap">
                                        <span
                                            class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                {{ $course->status->value === 'AKTIF' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                            {{ $course->status->value }}
                                        </span>
                                    </td>
                                    <td class=" gap-4 items-center  py-2">
                                        <a href="courses/{{ $course->id }}/edit">
                                            <button
                                                class="bg-yellow-400 hover:bg-yellow-500 font-semibold mb-2 py-2 rounded-lg shadow-lg hover:shadow-xl flex items-center justify-center px-6 text-white cursor-pointer">
                                                <i class="fas fa-edit mr-3"></i> Edit Course
                                            </button>
                                        </a>
                                        <div>
                                            <button @click="open = true"
                                                class="bg-red-600 font-semibold py-2 rounded-lg shadow-lg hover:shadow-xl hover:bg-red-700 flex items-center justify-center px-6 text-white cursor-pointer">
                                                <i class="fas fa-edit mr-3"></i> Delete Course
                                            </button>

                                            @include('partials.delete-modalbox', [
                                                'title' => 'Delete Course',
                                                'message' =>
                                                    'Are you sure you want to delete course ' .
                                                    $course->name .
                                                    '?',
                                                'route' => route('courses.destroy', $course->id),
                                            ])
                                        </div>

                                    </td>
                                </tr>
                            @endforeach

                        @endif
                    </tbody>
                    </tbody>
                </table>
            </div>


        </div>
    </main>
@endsection

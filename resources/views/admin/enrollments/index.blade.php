@extends('layouts.app')
@section('title', 'Lessons')

@section('content')
    <main class="w-full flex-grow p-6">
        <h1 class="text-3xl text-black pb-4">Lessons</h1>

        <div class="w-full mb-6">
            <p class="text-xl pb-3 flex items-center">
                <i class="fas fa-book mr-3"></i> Lessons for: <strong class="ml-1">{{ $course->title }}</strong>
            </p>
            <div class="w-full overflow-x-auto">
                <div class="flex justify-end my-4">
                    <form method="GET" action="{{ route('courses.enrollments.index', $course) }}" class="mb-4 flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama, email, atau status..." class="border px-4 py-2 rounded " />
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Cari
                        </button>
                    </form>


                </div>
                <table class="min-w-[900px] table-fixed w-full border-collapse bg-white rounded-lg shadow">
                    <thead class="bg-gray-100">
                        <tr class="text-xs font-semibold text-gray-600 uppercase text-center">
                            <th class="w-[10%] px-4 py-2 whitespace-nowrap">#</th>
                            <th class="w-[30%] px-4 py-2 whitespace-nowrap">Student Name</th>
                            <th class="w-[30%] px-4 py-2 whitespace-nowrap">Email</th>
                            <th class="w-[30%] px-4 py-2 whitespace-nowrap">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enrollments as $enrollment)
                            <tr x-data="{ open: false }" class="bg-white border-b border-gray-200 text-sm text-gray-900">
                                <td class="px-4 py-2 text-center">
                                    {{ $loop->iteration }}.
                                </td>
                                <td class="px-4 py-2 text-center font-medium">
                                    {{ $enrollment->student->name }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    {{ $enrollment->student->email }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    {{ $enrollment->status }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-5 text-center text-gray-500">
                                    No lessons found for this course.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $enrollments->links() }}
                </div>

            </div>
        </div>
    </main>
@endsection

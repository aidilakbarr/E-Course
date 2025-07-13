@extends('layouts.app')
@section('title', 'Table')

@section('content')
    <main class="w-full flex-grow p-6">
        <h1 class="text-3xl text-black pb-4">Tables</h1>
        <div class="w-full">
            <p class="text-xl pb-3 flex items-center">
                <i class="fas fa-list mr-3"></i> Table User
            </p>
            <a href="table/create">
                <button
                    class="bg-[#3d68ff] font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-[#3a4e94] flex items-center justify-center px-6 text-white cursor-pointer">
                    <i class="fas fa-plus mr-3 text-white"></i> New User
                </button>
            </a>
            <div class="bg-white overflow-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th
                                class="px-2 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-nowrap">
                                User
                            </th>
                            <th
                                class="px-2 py-2 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase whitespace-nowrap w-px h-full">
                                Email
                            </th>
                            <th
                                class="px-2 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-nowrap">
                                Role
                            </th>
                            <th
                                class="px-2 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-nowrap">
                                Created At
                            </th>
                            <th
                                class="px-2 py-2 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase whitespace-nowrap w-fit">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->isEmpty())
                            <td colspan="5" class="px-5 py-5 border-b bg-white border-gray-200  text-sm w-full">
                                <div class="text-center w-full ">
                                    Tidak ada data
                                </div>
                            </td>
                        @else
                            @foreach ($users as $user)
                                <tr x-data="{ open: false }">
                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-10 h-10">
                                                <img class="w-full h-full rounded-full"
                                                    src="{{ $user->profile ? asset('storage/' . $user->profile) : asset('images/default-profile.png') }}"
                                                    alt="" />
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{ $user->name }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        <span
                                            class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                            <span aria-hidden
                                                class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                            <span class="relative">{{ $user->email }}</span>
                                        </span>
                                    </td>
                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $user->role ?? 'Admin' }}</p>
                                    </td>
                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{ $user->created_at->format('D j M o') }}
                                        </p>
                                    </td>
                                    <td class="flex w-full justify-center gap-4 items-center  py-2">
                                        <a href="table/{{ $user->id }}/edit">
                                            <button
                                                class="bg-[#3d68ff] font-semibold py-2 rounded-lg shadow-lg hover:shadow-xl hover:bg-[#3a4e94] flex items-center justify-center px-6 text-white cursor-pointer">
                                                <i class="fas fa-edit mr-3"></i> Edit User
                                            </button>
                                        </a>

                                        <div>
                                            <button @click="open = true"
                                                class="bg-red-600 font-semibold py-2 rounded-lg shadow-lg hover:shadow-xl hover:bg-red-700 flex items-center justify-center px-6 text-white cursor-pointer">
                                                <i class="fas fa-edit mr-3"></i> Delete User
                                            </button>
                                            @include('partials.delete-modalbox', [
                                                'title' => 'Delete User',
                                                'message' =>
                                                    'Are you sure you want to delete user ' . $user->name . '?',
                                                'route' => route('table.destroy', $user->id),
                                            ])
                                        </div>

                                    </td>

                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection

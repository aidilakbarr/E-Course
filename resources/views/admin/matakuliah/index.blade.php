@extends('layouts.app')
@section('title', 'Manajemen Kelas')

@section('content')
    <main class="w-full flex-grow p-6">
        <h1 class="text-3xl text-black pb-4">Manajemen Kelas</h1>
        <div class="w-full">
            <p class="text-xl pb-3 flex items-center">
                <i class="fas fa-chalkboard mr-3"></i> Daftar Kelas
            </p>
            <div class="w-full overflow-x-auto">
                <div class="flex justify-between my-4">
                    <a href="{{ route('matakuliah.create') }}">
                        <button
                            class="bg-blue-600 font-semibold py-2 rounded shadow hover:bg-blue-700 flex items-center justify-center px-6 text-white">
                            <i class="fas fa-plus mr-2"></i> Kelas Baru
                        </button>
                    </a>

                    <form method="GET" action="{{ route('matakuliah.index') }}" class="mb-4">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama matkul..." class="border px-4 py-2 rounded" />
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded ml-2 hover:bg-blue-700">
                            Cari
                        </button>
                    </form>
                </div>

                <table class="min-w-[800px] table-fixed w-full border-collapse bg-white rounded-lg shadow">
                    <thead class="bg-gray-100">
                        <tr class="text-xs font-semibold text-gray-600 uppercase text-center">
                            <th class="w-[10%] px-4 py-2">Kode</th>
                            <th class="w-[25%] px-4 py-2">Nama Mata Kuliah</th>
                            <th class="w-[20%] px-4 py-2">Dosen Pengampu</th>
                            <th class="w-[15%] px-4 py-2">Semester</th>
                            <th class="w-[15%] px-4 py-2">Kelas</th>
                            <th class="w-[15%] px-4 py-2">Ruangan</th>
                            <th class="w-[15%] px-4 py-2">Kapasitas</th>
                            <th class="w-[15%] px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="matakuliah-table-body">
                        <td colspan="6" class="px-5 py-5 text-center text-gray-500">Loading data...</td>
                    </tbody>
                </table>
                <nav class="flex justify-center items-center p-1 rounded bg-white space-x-2 mt-4">
                    <a class="p-1 rounded border text-black bg-white hover:text-white hover:bg-blue-600 hover:border-blue-600"
                        id="prev-btn" href="#">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
                        </svg>
                    </a>
                    <p class="text-gray-500" id="page-info">Page 1 of 10</p>
                    <a class="p-1 rounded border text-black bg-white hover:text-white hover:bg-blue-600 hover:border-blue-600"
                        id="next-btn" href="#">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                    </a>
                </nav>
            </div>
        </div>
    </main>
@endsection

<script type="module" src="/js/pages/matakuliah.js"></script>

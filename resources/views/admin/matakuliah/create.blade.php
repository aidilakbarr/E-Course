@extends('layouts.app')
@section('title', 'Add Course')

@section('content')
    <main class="w-full flex-grow p-6">
        <h1 class="text-3xl text-black pb-6">Tambah Mata Kuliah</h1>

        <div class="w-full lg:w-1/2">
            <form id="matakuliahForm" class="p-10 bg-white rounded shadow-xl">

                {{-- kode Mata Kuliah --}}
                <div class="mb-4">
                    <label for="kode" class="block text-sm text-gray-600">Kode Mata Kuliah</label>
                    <input type="text" name="kode" id="kode" class="w-full px-5 py-2 bg-gray-200 rounded" required>
                    <p class="text-sm text-red-500 mt-1" id="error-kode"></p>
                </div>

                {{-- Nama Mata Kuliah --}}
                <div class="mb-4">
                    <label for="nama" class="block text-sm text-gray-600">Nama Mata Kuliah</label>
                    <input type="text" name="nama" id="nama" class="w-full px-5 py-2 bg-gray-200 rounded"
                        required>
                    <p class="text-sm text-red-500 mt-1" id="error-nama"></p>
                </div>

                {{-- Semester --}}
                <div class="mb-4">
                    <label for="semester" class="block text-sm text-gray-600">Semester</label>
                    <select name="semester" id="semester" class="w-full px-5 py-2 bg-gray-200 rounded" required>
                        @for ($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}">Semester {{ $i }}</option>
                        @endfor
                    </select>
                    <p class="text-sm text-red-500 mt-1" id="error-semester"></p>
                </div>

                {{-- SKS --}}
                <div class="mb-4">
                    <label class="block text-sm text-gray-600">SKS</label>
                    <div class="flex gap-4">
                        @foreach ([2, 3, 4] as $sks)
                            <label>
                                <input type="radio" name="sks" value="{{ $sks }}" required>
                                {{ $sks }} SKS
                            </label>
                        @endforeach
                    </div>
                    <p class="text-sm text-red-500 mt-1" id="error-sks"></p>
                </div>

                {{-- Dosen Pengampu --}}
                <div class="mb-4">
                    <label for="dosen_id" class="block text-sm text-gray-600">Dosen Pengampu</label>
                    <select name="dosen_id" id="dosen_id" class="w-full px-5 py-2 bg-gray-200 rounded" required></select>
                    <p class="text-sm text-red-500 mt-1" id="error-dosen_id"></p>
                </div>

                {{-- Kelas (fixed A) --}}
                <div class="mb-4">
                    <label class="block text-sm text-gray-600">Kelas</label>
                    <input type="text" name="kelas" value="Kelas A" class="w-full px-5 py-2 bg-gray-200 rounded"
                        readonly>
                </div>

                {{-- Kapasitas Mahasiswa --}}
                <div class="mb-4">
                    <label for="capacity" class="block text-sm text-gray-600">Kapasitas Mahasiswa</label>
                    <input type="number" name="kapasitas" id="kapasitas" class="w-full px-5 py-2 bg-gray-200 rounded"
                        required>
                    <p class="text-sm text-red-500 mt-1" id="error-capacity"></p>
                </div>

                {{-- Hari dan Jam --}}
                <div class="mb-4">
                    <label class="block text-sm text-gray-600">Hari & Jam Kuliah</label>
                    <div class="flex gap-4">
                        <select name="hari" class="px-4 py-2 bg-gray-200 rounded" required>
                            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        </select>
                        <input type="time" name="jam_mulai" required class="px-4 py-2 bg-gray-200 rounded">
                        <input type="time" name="jam_selesai" required class="px-4 py-2 bg-gray-200 rounded">
                    </div>
                    <p class="text-sm text-red-500 mt-1" id="error-day"></p>
                </div>

                {{-- Ruangan --}}
                <div class="mb-4">
                    <label for="room" class="block text-sm text-gray-600">Ruangan</label>
                    <input type="text" name="ruangan" id="ruangan" class="w-full px-5 py-2 bg-gray-200 rounded"
                        required>
                    <p class="text-sm text-red-500 mt-1" id="error-ruangan"></p>
                </div>

                {{-- Submit --}}
                <div class="mt-6">
                    <button type="submit" id="submitBtn"
                        class="px-4 py-2 text-white font-semibold bg-[#3d68ff] hover:bg-[#2d56d9] rounded flex items-center justify-center gap-2">
                        <span id="submitText">Submit</span>
                        <span id="submitLoading"
                            class="hidden animate-spin border-t-2 border-white border-solid rounded-full h-4 w-4"></span>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script type="module">
        import apiClient from '/js/utils/apiClient.js';

        const form = document.getElementById('matakuliahForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const submitLoading = document.getElementById('submitLoading');

        const showErrors = (errors) => {
            for (const key in errors) {
                const errorElem = document.getElementById(`error-${key}`);
                if (errorElem) {
                    errorElem.textContent = errors[key][0];
                }
            }
        };

        const clearErrors = () => {
            document.querySelectorAll('[id^="error-"]').forEach(elem => {
                elem.textContent = '';
            });
        };

        async function loadLectures() {
            try {
                const res = await apiClient.get('/show-dosen');
                const lectures = res.data.data;

                console.log({
                    res
                })

                const select = document.getElementById('dosen_id');
                lectures.forEach(lecture => {
                    const opt = document.createElement('option');
                    opt.value = lecture.id;
                    opt.textContent = lecture.user.name;
                    select.appendChild(opt);
                });
            } catch (err) {
                console.error("Gagal load dosen:", err);
            }
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            clearErrors();

            const formData = new FormData(form);
            submitBtn.disabled = true;
            submitText.textContent = "Saving...";
            submitLoading.classList.remove('hidden');

            const data = Object.fromEntries(formData.entries());
            console.log(data);


            try {
                const res = await apiClient.post('/matakuliah', formData);
                alert('Berhasil tambah mata kuliah!');
                console.log({
                    res
                })
                window.location.href = "/matakuliah";
            } catch (err) {
                if (err.response && err.response.status === 422) {
                    showErrors(err.response.data.errors);
                } else {
                    alert('Terjadi kesalahan saat menyimpan.');
                    console.error(err);
                }
            } finally {
                submitBtn.disabled = false;
                submitText.textContent = "Submit";
                submitLoading.classList.add('hidden');
            }
        });

        loadLectures();
    </script>
@endsection

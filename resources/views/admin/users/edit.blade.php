@extends('layouts.app')
@section('title', 'Edit User')

@section('content')
    <main class="w-full flex-grow p-6">
        <h1 class="w-full text-3xl text-black pb-6">Forms</h1>

        <div class="flex flex-wrap">
            <div class="w-full lg:w-1/2 my-6 pr-0 lg:pr-2">
                <p class="text-xl pb-6 flex items-center">
                    <i class="fas fa-user-edit mr-3"></i> Edit User
                </p>
                <div class="leading-loose">
                    <form id="userForm" class="p-10 bg-white rounded shadow-xl" enctype="multipart/form-data">
                        {{-- Profile Photo --}}
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600" for="add-profile_url">Profile Photo</label>
                            <input type="file" name="profile_url" id="add-profile_url"
                                class="w-full px-5 py-2 bg-gray-200 rounded">
                            <p class="text-sm text-red-500 mt-1" id="error-profile_url"></p>
                        </div>

                        {{-- Name --}}
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600" for="add-name">Name</label>
                            <input type="text" name="name" id="add-name" class="w-full px-5 py-2 bg-gray-200 rounded"
                                required>
                            <p class="text-sm text-red-500 mt-1" id="error-name"></p>
                        </div>

                        {{-- Email --}}
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600" for="add-email">Email</label>
                            <input type="email" name="email" id="add-email" class="w-full px-5 py-2 bg-gray-200 rounded"
                                required>
                            <p class="text-sm text-red-500 mt-1" id="error-email"></p>
                        </div>

                        {{-- Password --}}
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600" for="add-password">Password
                                <small class="text-gray-400">(Kosongkan jika tidak diubah)</small>
                            </label>
                            <input type="password" name="password" id="add-password"
                                class="w-full px-5 py-2 bg-gray-200 rounded">
                            <p class="text-sm text-red-500 mt-1" id="error-password"></p>
                        </div>

                        {{-- Role --}}
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600" for="add-role">Role</label>
                            <select name="role" id="add-role" class="w-full px-5 py-2 bg-gray-200 rounded" required>
                                <option value="MAHASISWA">MAHASISWA</option>
                                <option value="DOSEN">DOSEN</option>
                                <option value="KAPRODI">KAPRODI</option>
                            </select>
                            <p class="text-sm text-red-500 mt-1" id="error-role"></p>
                        </div>

                        {{-- Submit --}}
                        <div class="mt-6">
                            <button type="submit" id="submitBtn"
                                class="px-4 py-2 text-white font-semibold bg-yellow-500 hover:bg-yellow-600 rounded flex items-center justify-center gap-2">
                                <span id="submitText">Update</span>
                                <span id="submitLoading"
                                    class="hidden animate-spin border-t-2 border-white border-solid rounded-full h-4 w-4"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script type="module">
        import apiClient from '/js/utils/apiClient.js';

        const form = document.getElementById('userForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const submitLoading = document.getElementById('submitLoading');

        const userId = window.location.pathname.split('/')[2];

        // Load user data
        const loadUserData = async () => {
            try {
                const res = await apiClient.get(`/users/${userId}`);
                const user = res.data.data;

                document.getElementById('add-name').value = user.name;
                document.getElementById('add-email').value = user.email;
                document.getElementById('add-role').value = user.role;
            } catch (err) {
                console.error('Gagal memuat data user:', err);
                alert('Data user tidak ditemukan.');
            }
        };

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

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            clearErrors();

            const formData = new FormData(form);
            formData.append('_method', 'PUT');

            submitBtn.disabled = true;
            submitText.textContent = "Updating...";
            submitLoading.classList.remove('hidden');

            try {
                const res = await apiClient.post(`/users/${userId}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                console.log(res)

                Swal.fire({
                    title: "Sukses!",
                    text: `${res.data.user.name} berhasil diperbarui`,
                    icon: "success",
                    timer: 2500
                });
                window.location.href = "/users";
            } catch (err) {
                if (err.response && err.response.status === 422) {
                    showErrors(err.response.data.errors);
                } else {
                    alert('Gagal memperbarui user');
                    console.error(err);
                }
            } finally {
                submitBtn.disabled = false;
                submitText.textContent = "Update";
                submitLoading.classList.add('hidden');
            }
        });

        loadUserData();
    </script>
@endsection

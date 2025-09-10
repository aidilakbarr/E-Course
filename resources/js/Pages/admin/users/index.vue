<template>
    <AdminLayout>
        <main class="w-full flex-grow p-6">
            <h1 class="text-3xl text-black pb-4">Manajemen Pengguna</h1>

            <div class="w-full">
                <p class="text-xl pb-3 flex items-center">
                    <i class="fas fa-users mr-3"></i> Daftar Pengguna
                </p>

                <div class="w-full overflow-x-auto">
                    <div class="flex justify-between items-center my-4">
                        <div class="flex items-center">
                            <button
                                @click="showImportForm = !showImportForm"
                                class="text-blue-600 hover:text-blue-800 text-2xl mr-2"
                            >
                                <i class="fas fa-file-import"></i>
                            </button>

                            <div
                                v-if="showImportForm"
                                class="max-w-xl mx-auto mt-10 p-6 bg-white shadow-md rounded-md"
                            >
                                <h2 class="text-xl font-semibold mb-4">
                                    Import Data User dari Excel
                                </h2>
                                <form>
                                    <div class="mb-4">
                                        <label
                                            for="excelFile"
                                            class="block text-gray-700 font-medium mb-2"
                                        >
                                            Pilih File Excel
                                        </label>
                                        <input
                                            type="file"
                                            id="excelFile"
                                            name="file"
                                            accept=".xlsx,.xls"
                                            class="w-full border border-gray-300 rounded px-3 py-2"
                                        />
                                    </div>
                                    <button
                                        type="submit"
                                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                                    >
                                        Import
                                    </button>
                                </form>
                            </div>

                            <Link href="/users/create">
                                <button
                                    class="bg-blue-600 font-semibold py-2 rounded shadow hover:bg-blue-700 flex items-center justify-center px-6 text-white"
                                >
                                    <i class="fas fa-user-plus mr-2"></i>
                                    Pengguna Baru
                                </button>
                            </Link>
                        </div>

                        <div class="mb-4 flex">
                            <input
                                v-model="search"
                                type="text"
                                placeholder="Cari nama/email..."
                                class="border px-4 py-2 rounded"
                                @keyup.enter="handleSearch"
                            />
                            <button
                                @click.prevent="handleSearch"
                                class="bg-blue-600 text-white px-4 py-2 rounded ml-2 hover:bg-blue-700"
                            >
                                Cari
                            </button>
                        </div>
                    </div>

                    <table
                        class="min-w-[800px] table-fixed w-full border-collapse bg-white rounded-lg shadow"
                    >
                        <thead class="bg-gray-100">
                            <tr
                                class="text-xs font-semibold text-gray-600 uppercase text-center"
                            >
                                <th class="w-[10%] px-4 py-2">Foto</th>
                                <th class="w-[20%] px-4 py-2">Nama</th>
                                <th class="w-[25%] px-4 py-2">Email</th>
                                <th class="w-[15%] px-4 py-2">Role</th>
                                <th class="w-[20%] px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="user-table-body">
                            <tr v-for="user in users" :key="user.id">
                                <td class="text-center py-2">
                                    <img
                                        :src="
                                            user.profile
                                                ? `/storage/${user.profile}`
                                                : `https://ui-avatars.com/api/?name=${encodeURIComponent(
                                                      user.name
                                                  )}&background=random&color=fff`
                                        "
                                        alt="Profile"
                                        class="w-12 h-12 rounded-full shadow block mx-auto"
                                    />
                                </td>
                                <td class="py-2 text-center">
                                    {{ user.name }}
                                </td>
                                <td class="py-2 text-center">
                                    {{ user.email }}
                                </td>
                                <td class="text-center">
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full"
                                        :class="{
                                            'bg-blue-100 text-blue-800':
                                                user.role === 'ADMIN',
                                            'bg-yellow-100 text-yellow-800':
                                                user.role === 'DOSEN',
                                            'bg-green-100 text-green-800':
                                                user.role === 'KAPRODI',
                                            'bg-gray-100 text-gray-700': ![
                                                'ADMIN',
                                                'DOSEN',
                                                'KAPRODI',
                                            ].includes(user.role),
                                        }"
                                    >
                                        <i
                                            class="fas"
                                            :class="{
                                                'fa-user-shield':
                                                    user.role === 'ADMIN',
                                                'fa-chalkboard-teacher':
                                                    user.role === 'DOSEN',
                                                'fa-user-tie':
                                                    user.role === 'KAPRODI',
                                                'fa-user': ![
                                                    'ADMIN',
                                                    'DOSEN',
                                                    'KAPRODI',
                                                ].includes(user.role),
                                            }"
                                        ></i>
                                        {{ user.role }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="flex gap-2 justify-center">
                                        <Link
                                            :href="`/users/${user.id}/edit`"
                                            title="Edit"
                                        >
                                            <button
                                                class="text-yellow-500 hover:text-yellow-600 cursor-pointer"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </Link>

                                        <button
                                            @click="
                                                handleDelete(user.id, user.name)
                                            "
                                            class="text-red-500 hover:text-red-700 cursor-pointer"
                                            title="Hapus"
                                        >
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="flex items-center gap-2 mt-4">
                        <button
                            @click="goToPage(pagination.current_page - 1)"
                            :disabled="pagination.current_page === 1"
                            class="px-3 py-1 border rounded disabled:opacity-50"
                        >
                            Prev
                        </button>

                        <button
                            class="px-3 py-1 border rounded"
                            :class="{
                                'bg-blue-500 text-white':
                                    page === pagination.current_page,
                            }"
                        >
                            {{ pagination.current_page }}
                        </button>

                        <button
                            @click="goToPage(pagination.current_page + 1)"
                            :disabled="
                                pagination.current_page === pagination.last_page
                            "
                            class="px-3 py-1 border rounded disabled:opacity-50"
                        >
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </AdminLayout>
</template>

<script setup>
import { computed, ref } from "vue";
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { Link, router, usePage } from "@inertiajs/vue3";
const page = usePage();
import * as yup from "yup";

const users = computed(() => page.props.users.data);
const pagination = computed(() => page.props.users);

const search = ref(page.props.filters?.search || "");

const showImportForm = ref(false);

const schema = yup.object({
    file: yup.mixed(),
});

const goToPage = (pageNumber) => {
    if (pageNumber < 1 || pageNumber > pagination.value.last_page) return;

    router.get(
        "/users",
        { page: pageNumber, search: search.value },
        { preserveScroll: true, preserveState: true }
    );
};

// Submit search
const handleSearch = () => {
    router.get(
        "/users",
        { search: search.value },
        { preserveScroll: true, preserveState: true }
    );
};

const handleDelete = (id, name) => {
    Swal.fire({
        title: `Yakin hapus ${name}?`,
        text: "Data ini tidak bisa dikembalikan lagi!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/users/${id}`, {
                preserveScroll: true,
                preserveState: false,
            });
        }
    });
};
</script>

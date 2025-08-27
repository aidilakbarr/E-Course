<template>
    <AdminLayout>
        <main class="w-full flex-grow p-6">
            <h1 class="text-3xl text-black pb-4">Manajemen Kelas</h1>
            <div class="w-full">
                <p class="text-xl pb-3 flex items-center">
                    <i class="fas fa-chalkboard mr-3"></i> Daftar Kelas
                </p>

                <div class="w-full overflow-x-auto">
                    <!-- Toolbar -->
                    <div class="flex justify-between my-4">
                        <Link href="/matakuliah/create">
                            <button
                                class="bg-blue-600 font-semibold py-2 rounded shadow hover:bg-blue-700 flex items-center justify-center px-6 text-white"
                            >
                                <i class="fas fa-plus mr-2"></i> Kelas Baru
                            </button>
                        </Link>

                        <form @submit.prevent="handleSearch" class="mb-4 flex">
                            <input
                                v-model="search"
                                type="text"
                                placeholder="Cari nama matkul..."
                                class="border px-4 py-2 rounded"
                            />
                            <button
                                type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded ml-2 hover:bg-blue-700"
                            >
                                Cari
                            </button>
                        </form>
                    </div>

                    <!-- Table -->
                    <table
                        class="min-w-[800px] table-fixed w-full border-collapse bg-white rounded-lg shadow"
                    >
                        <thead class="bg-gray-100">
                            <tr
                                class="text-xs font-semibold text-gray-600 uppercase text-center"
                            >
                                <th class="px-4 py-2">Kode</th>
                                <th class="px-4 py-2">Nama Mata Kuliah</th>
                                <th class="px-4 py-2">Dosen Pengampu</th>
                                <th class="px-4 py-2">Semester</th>
                                <th class="px-4 py-2">Kelas</th>
                                <th class="px-4 py-2">Ruangan</th>
                                <th class="px-4 py-2">Kapasitas</th>
                                <th class="px-4 py-2">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="matakuliah in matakuliahs.data"
                                :key="matakuliah.id"
                                class="text-sm border-b"
                            >
                                <td class="py-2 text-center">
                                    {{ matakuliah.kode }}
                                </td>
                                <td class="py-2 text-center">
                                    {{ matakuliah.nama }}
                                </td>
                                <td class="py-2 text-center">
                                    {{ matakuliah.dosen?.user?.name }}
                                </td>
                                <td class="py-2 text-center">
                                    {{ matakuliah.semester }}
                                </td>
                                <td class="py-2 text-center">
                                    {{ matakuliah.kelas }}
                                </td>
                                <td class="py-2 text-center">
                                    {{ matakuliah.ruangan }}
                                </td>
                                <td class="py-2 text-center">
                                    {{ matakuliah.kapasitas }}
                                </td>
                                <td class="text-center">
                                    <div class="flex justify-center gap-2">
                                        <Link
                                            :href="`/matakuliah/${matakuliah.id}/edit`"
                                            title="Edit"
                                        >
                                            <button
                                                class="text-yellow-500 hover:text-yellow-600"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </Link>
                                        <button
                                            @click="
                                                handleDelete(
                                                    matakuliah.id,
                                                    matakuliah.nama
                                                )
                                            "
                                            class="text-red-500 hover:text-red-600"
                                            title="Hapus"
                                        >
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="!matakuliahs.data.length">
                                <td
                                    colspan="8"
                                    class="text-center text-gray-500 py-4"
                                >
                                    Tidak ada data mata kuliah.
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <nav
                        class="flex justify-center items-center p-1 rounded bg-white space-x-2 mt-4"
                    >
                        <button
                            @click="prevPage"
                            :disabled="matakuliahs.current_page === 1"
                            class="p-1 rounded border text-black bg-white hover:text-white hover:bg-blue-600 hover:border-blue-600 disabled:opacity-50"
                        >
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <p class="text-gray-500">
                            Page {{ matakuliahs.current_page }} of
                            {{ matakuliahs.last_page }}
                        </p>
                        <button
                            @click="nextPage"
                            :disabled="
                                matakuliahs.current_page ===
                                matakuliahs.last_page
                            "
                            class="p-1 rounded border text-black bg-white hover:text-white hover:bg-blue-600 hover:border-blue-600 disabled:opacity-50"
                        >
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </nav>
                </div>
            </div>
        </main>
    </AdminLayout>
</template>

<script setup>
import { ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "../../../Layouts/AdminLayout.vue";

const props = defineProps({
    matakuliahs: Object,
    filters: Object,
});

const search = ref(props.filters?.search || "");

const handleSearch = () => {
    router.get(
        "/matakuliah",
        { search: search.value },
        { preserveState: true, replace: true }
    );
};

const prevPage = () => {
    if (props.matakuliahs.current_page > 1) {
        router.get(
            "/matakuliah",
            { page: props.matakuliahs.current_page - 1, search: search.value },
            { preserveState: true }
        );
    }
};

const nextPage = () => {
    if (props.matakuliahs.current_page < props.matakuliahs.last_page) {
        router.get(
            "/matakuliah",
            { page: props.matakuliahs.current_page + 1, search: search.value },
            { preserveState: true }
        );
    }
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
            router.delete(`/matakuliah/${id}`, {
                preserveScroll: true,
                preserveState: false,
            });
        }
    });
};
</script>

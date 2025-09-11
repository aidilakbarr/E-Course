<template>
    <AdminLayout>
        <div class="p-6 bg-gray-50 min-h-screen">
            <div class="max-w-6xl mx-auto">
                <header class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-semibold">
                        Validasi & Monitor KRS Mahasiswa
                    </h1>
                    <div class="flex gap-2 items-center">
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Cari nama/email..."
                            class="border px-4 py-2 rounded"
                            @keyup.enter="handleSearch"
                        />
                        <select
                            v-model="statusFilter"
                            class="border rounded px-3 py-2"
                        >
                            <option value="">Semua status</option>
                            <option value="WAITING">WAITING</option>
                            <option value="ACCEPTED">ACCEPTED</option>
                            <option value="REJECTED">REJECTED</option>
                            <option value="COMPLETED">COMPLETED</option>
                        </select>
                        <button
                            @click.prevent="handleSearch"
                            class="bg-blue-600 text-white px-4 py-2 rounded"
                        >
                            Refresh
                        </button>
                    </div>
                </header>

                <section class="bg-white shadow rounded">
                    <div>
                        <table class="w-full table-auto text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-3 text-left">NIM</th>
                                    <th class="p-3 text-left">Nama</th>
                                    <th class="p-3 text-left">Semester</th>
                                    <th class="p-3 text-left">Jumlah Matkul</th>
                                    <th class="p-3 text-left">Status</th>
                                    <th class="p-3 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="loading">
                                    <td colspan="7" class="p-6 text-center">
                                        Memuat...
                                    </td>
                                </tr>
                                <tr
                                    v-for="item in krs"
                                    :key="item.id"
                                    class="border-b hover:bg-gray-50"
                                >
                                    <td class="p-3">
                                        {{ item.mahasiswa.nim }}
                                    </td>
                                    <td class="p-3">
                                        {{ item.mahasiswa.user?.name }}
                                    </td>
                                    <td class="p-3">
                                        {{ item.mahasiswa.angkatan }}
                                    </td>
                                    <td class="p-3">
                                        {{ item.matakuliahs.length }}
                                    </td>
                                    <td class="p-3">
                                        <span
                                            :class="statusBadge(item.status)"
                                            >{{ item.status }}</span
                                        >
                                    </td>
                                    <td class="p-3">
                                        <div class="flex gap-2">
                                            <button
                                                @click="openModal(item)"
                                                class="px-3 py-1 rounded border"
                                            >
                                                Lihat
                                            </button>
                                            <button
                                                @click="
                                                    validateKRS(
                                                        item.id,
                                                        'accept'
                                                    )
                                                "
                                                :disabled="
                                                    item.status === 'ACCEPTED'
                                                "
                                                class="px-3 py-1 rounded bg-green-600 text-white disabled:opacity-50"
                                            >
                                                Terima
                                            </button>
                                            <button
                                                @click="
                                                    validateKRS(
                                                        item.id,
                                                        'reject'
                                                    )
                                                "
                                                :disabled="
                                                    item.status === 'REJECTED'
                                                "
                                                class="px-3 py-1 rounded bg-red-600 text-white disabled:opacity-50"
                                            >
                                                Tolak
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr v-if="!loading && !krs.length">
                                    <td
                                        colspan="7"
                                        class="p-6 text-center text-gray-500"
                                    >
                                        Tidak ada data
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4 flex items-center justify-between">
                        <div>
                            <button
                                @click="prevPage"
                                :disabled="meta.page === 1"
                                class="px-3 py-1 border rounded mr-2"
                            >
                                Prev
                            </button>
                            <button
                                @click="nextPage"
                                :disabled="meta.page === meta.last_page"
                                class="px-3 py-1 border rounded"
                            >
                                Next
                            </button>
                        </div>
                        <div class="text-sm text-gray-600">
                            Halaman {{ meta.page }} dari {{ meta.last_page }}
                        </div>
                    </div>
                </section>

                <!-- Modal -->
                <transition name="modal">
                    <div
                        v-if="showModal"
                        class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
                    >
                        <div
                            class="bg-white w-11/12 md:w-3/4 rounded shadow-lg overflow-hidden"
                        >
                            <div
                                class="p-4 border-b flex items-center justify-between"
                            >
                                <div>
                                    <h3 class="font-semibold">
                                        Detail KRS -
                                        {{ selectedKRS.mahasiswa.user.name }}
                                        ({{ selectedKRS.mahasiswa.nim }})
                                    </h3>
                                    <div class="text-xs text-gray-500">
                                        Semester:
                                        {{
                                            getSemester(
                                                selectedKRS.mahasiswa.angkatan
                                            )
                                        }}
                                    </div>
                                </div>
                                <button @click="closeModal" class="px-3 py-1">
                                    ✕
                                </button>
                            </div>

                            <div class="p-4">
                                <h4 class="font-medium mb-2">
                                    Daftar Mata Kuliah
                                </h4>
                                <div class="overflow-auto max-h-72">
                                    <table class="w-full text-sm">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="p-2 text-left">
                                                    Kode
                                                </th>
                                                <th class="p-2 text-left">
                                                    Matkul
                                                </th>
                                                <th class="p-2 text-left">
                                                    SKS
                                                </th>
                                                <th class="p-2 text-left">
                                                    Dosen
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="c in selectedKRS.matakuliahs"
                                                :key="c.id"
                                                class="border-b"
                                            >
                                                <td class="p-2">
                                                    {{ c.kode }}
                                                </td>
                                                <td class="p-2">
                                                    {{ c.nama }}
                                                </td>
                                                <td class="p-2">{{ c.sks }}</td>
                                                <td class="p-2">
                                                    {{ c.dosen_id }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-4 flex gap-2">
                                    <button
                                        @click="
                                            validateKRS(
                                                selectedKRS.id,
                                                'accept'
                                            )
                                        "
                                        class="px-4 py-2 rounded bg-green-600 text-white"
                                    >
                                        Terima
                                    </button>
                                    <button
                                        @click="
                                            validateKRS(
                                                selectedKRS.id,
                                                'reject'
                                            )
                                        "
                                        class="px-4 py-2 rounded bg-red-600 text-white"
                                    >
                                        Tolak
                                    </button>
                                    <button
                                        @click="closeModal"
                                        class="px-4 py-2 rounded border"
                                    >
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, reactive, computed } from "vue";
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { router, usePage } from "@inertiajs/vue3";
const page = usePage();
const loading = ref(false);
const selectedIds = ref([]);
const showModal = ref(false);
const krs = computed(() => page.props.krs.data);
const meta = computed(() => page.props.krs);
const search = ref(page.props.filters?.search || "");
const statusFilter = ref(page.props.filters?.status || "");
const selectedKRS = reactive({
    id: null,
    nim: "",
    nama: "",
    semester: "",
    courses: [],
    status: "",
});

function statusBadge(status) {
    const base = "px-2 py-1 rounded text-xs font-medium ";
    switch (status) {
        case "SUBMITTED":
            return base + "bg-yellow-100 text-yellow-800";
        case "ACCEPTED":
            return base + "bg-green-100 text-green-800";
        case "REJECTED":
            return base + "bg-red-100 text-red-800";
        default:
            return base + "bg-gray-100 text-gray-700";
    }
}

const handleSearch = () => {
    console.log("masuk");
    router.get(
        "/krs/submitted",
        { search: search.value, status: statusFilter.value },
        { preserveScroll: true, preserveState: true }
    );
    console.log(krs);
};

function openModal(k) {
    console.log({ k });

    Object.assign(selectedKRS, k);
    showModal.value = true;
}
function closeModal() {
    showModal.value = false;
}

async function validateKRS(id, action) {
    if (action === "accept") {
        router.put(`/krs/${id}/${action}`);
    }
}

const getSemester = (angkatan) => {
    const tahunSekarang = new Date().getFullYear();
    const bulanSekarang = new Date().getMonth() + 1;

    const semesterBerjalan = bulanSekarang >= 7 ? 1 : 2;

    const selisih = tahunSekarang - parseInt(angkatan);
    return selisih * 2 + semesterBerjalan;
};

function prevPage() {
    if (meta.page > 1) fetchKRS(meta.page - 1);
}
function nextPage() {
    if (meta.page < meta.last_page) fetchKRS(meta.page + 1);
}
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.2s;
}
.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}
</style>

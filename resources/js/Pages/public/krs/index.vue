<template>
    <AdminLayout>
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <div class="flex space-x-4">
                    <button
                        @click="switchTab('pilih')"
                        :class="[
                            activeTab === 'pilih'
                                ? 'text-blue-600 font-semibold border-b-2 border-blue-600'
                                : 'text-gray-500',
                        ]"
                    >
                        Pilih Kelas
                    </button>
                    <button
                        @click="switchTab('tersimpan')"
                        :class="[
                            activeTab === 'tersimpan'
                                ? 'text-blue-600 font-semibold border-b-2 border-blue-600'
                                : 'text-gray-500',
                        ]"
                    >
                        KRS Tersimpan
                    </button>
                </div>
                <div
                    v-if="activeTab === 'tersimpan'"
                    class="text-sm text-gray-600"
                >
                    Total SKS: {{ totalSKS }}
                </div>
            </div>

            <div v-if="activeTab === 'pilih'">
                <table class="w-full text-sm text-left text-gray-600 border">
                    <thead class="text-xs uppercase bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-3">Aksi</th>
                            <th class="px-4 py-3">Nama Kelas</th>
                            <th class="px-4 py-3">Hari</th>
                            <th class="px-4 py-3">Jam</th>
                            <th class="px-4 py-3">SKS</th>
                            <th class="px-4 py-3">Semester</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="matkul in dataMatkul"
                            :key="matkul.id"
                            class="border-b"
                        >
                            <td class="px-3 py-2">
                                <input
                                    type="checkbox"
                                    :checked="
                                        selectedMatkul.includes(matkul.id)
                                    "
                                    @change="toggleSelect(matkul.id)"
                                />
                            </td>
                            <td class="px-4 py-2">{{ matkul.nama }}</td>
                            <td class="px-4 py-2">{{ matkul.hari }}</td>
                            <td class="px-4 py-2">
                                {{ matkul.jam_mulai }} -
                                {{ matkul.jam_selesai }}
                            </td>
                            <td class="px-4 py-2">{{ matkul.sks }}</td>
                            <td class="px-4 py-2">{{ matkul.semester }}</td>
                        </tr>
                    </tbody>
                </table>
                <div
                    class="flex justify-between items-center mt-4 text-sm text-gray-700"
                >
                    <div>
                        {{ selectedMatkul.length }} kelas dipilih,
                        {{ totalSKS }} SKS dari {{ maxSKS }} SKS
                    </div>
                    <button
                        @click="simpanDraft"
                        class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700"
                    >
                        Simpan Draft
                    </button>
                </div>
            </div>

            <div v-if="activeTab === 'tersimpan'">
                <button
                    @click="downloadPDF()"
                    class="bg-green-600 text-white px-5 py-2 rounded mb-3"
                >
                    Download pdf
                </button>

                <table class="w-full text-sm text-left text-gray-600 border">
                    <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-2">Nama Kelas</th>
                            <th class="px-4 py-2">Hari</th>
                            <th class="px-4 py-2">Jam</th>
                            <th class="px-4 py-2">SKS</th>
                            <th class="px-4 py-2">Semester</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="mk in krsTersimpan"
                            :key="mk.id"
                            class="border-b"
                        >
                            <td class="px-4 py-2">{{ mk.nama }}</td>
                            <td class="px-4 py-2">{{ mk.hari }}</td>
                            <td class="px-4 py-2">
                                {{ mk.jam_mulai }} - {{ mk.jam_selesai }}
                            </td>
                            <td class="px-4 py-2">{{ mk.sks }}</td>
                            <td class="px-4 py-2">{{ mk.semester }}</td>
                            <td class="px-4 py-2">
                                <button
                                    @click="hapusMatkul(mk.id)"
                                    class="text-red-500 hover:text-red-600"
                                >
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div
                    class="flex justify-between items-center mt-4 text-sm text-gray-700"
                >
                    <div>{{ krsTersimpan.length }} kelas tersimpan</div>

                    <button
                        v-if="props?.status == 'SUBMITTED'"
                        @click="simpanKRS"
                        disabled
                        class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        KRS Tersimpan
                    </button>
                    <button
                        v-else
                        @click="simpanKRS"
                        class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700"
                    >
                        Simpan KRS
                    </button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
<script setup>
import { ref, computed, onMounted } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import axios from "axios";
const page = usePage();
const props = page.props;
const maxSKS = 24;
const activeTab = ref("pilih");
const selectedMatkul = ref([]);
const krsTersimpan = ref(props.krs?.matakuliahs || []);
const isDownloading = ref(false);

const dataMatkul = computed(() => {
    const idsTersimpan = krsTersimpan.value.map((m) => m.id);
    return props.matakuliah?.filter((m) => !idsTersimpan.includes(m.id));
});
const totalSKS = computed(() =>
    krsTersimpan.value.reduce((acc, m) => acc + (m.sks || 0), 0)
);

function switchTab(tab) {
    activeTab.value = tab;
}

function toggleSelect(id) {
    if (selectedMatkul.value.includes(id)) {
        selectedMatkul.value = selectedMatkul.value.filter((x) => x !== id);
    } else {
        selectedMatkul.value.push(id);
    }
}

async function downloadPDF() {
    if (isDownloading.value) return;
    isDownloading.value = true;
    try {
        const intervalId = setInterval(async () => {
            try {
                const response = await axios.get(`/krs/${props.krs?.id}/pdf`, {
                    responseType: "blob",
                    validateStatus: (status) =>
                        status === 200 || status === 202,
                    withCredentials: true,
                });

                if (response.status === 202) {
                    return;
                }

                clearInterval(intervalId);

                const blob = new Blob([response.data], {
                    type: "application/pdf",
                });
                const url = window.URL.createObjectURL(blob);
                const link = document.createElement("a");
                link.href = url;
                link.download = `krs-${props.krs?.id}.pdf`;
                document.body.appendChild(link);
                link.click();
                link.remove();
                window.URL.revokeObjectURL(url);

                isDownloading.value = false;
            } catch (err) {
                console.error(err);
                clearInterval(intervalId);
                isDownloading.value = false;
            }
        }, 1000);
    } catch (err) {
        console.error(err);
        isDownloading.value = false;
    }
}

function simpanDraft() {
    if (selectedMatkul.value.length === 0) {
        alert("Pilih minimal 1 mata kuliah.");
        return;
    }
    if (totalSKS.value > maxSKS) {
        alert(`Total SKS melebihi batas ${maxSKS}.`);
        return;
    }

    router.post("/krs/save", {
        matakuliah_ids: selectedMatkul.value,
    });
}

function simpanKRS() {
    router.put("/krs/store");
}

function hapusMatkul(matakuliahId) {
    router.delete(`/krs/${props.krs?.id}/matakuliah/${matakuliahId}`, [
        props.krs?.id,
        matakuliahId,
    ]);
}
</script>

<template>
    <AdminLayout>
        <main class="w-full flex-grow p-6">
            <h1 class="text-3xl text-black pb-6">Tambah Mata Kuliah</h1>

            <div class="w-full lg:w-1/2">
                <form
                    :validation-schema="schema"
                    @submit.prevent="submitForm"
                    class="p-10 bg-white rounded shadow-xl"
                >
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600"
                            >Kode Mata Kuliah</label
                        >
                        <input
                            v-model="kode"
                            type="text"
                            class="w-full px-5 py-2 bg-gray-200 rounded"
                        />
                        <span class="text-red-500 text-sm mt-1">
                            {{ errors.kode }}
                        </span>
                    </div>

                    <!-- Nama -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600"
                            >Nama Mata Kuliah</label
                        >
                        <input
                            v-model="nama"
                            type="text"
                            class="w-full px-5 py-2 bg-gray-200 rounded"
                        />
                        <span class="text-red-500 text-sm mt-1">
                            {{ errors.nama }}
                        </span>
                    </div>

                    <!-- Semester -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600"
                            >Semester</label
                        >
                        <select
                            v-model="semester"
                            class="w-full px-5 py-2 bg-gray-200 rounded"
                        >
                            <option disabled value="">Pilih Semester</option>
                            <option v-for="i in 8" :key="i" :value="i">
                                Semester {{ i }}
                            </option>
                        </select>
                        <span class="text-red-500 text-sm mt-1">
                            {{ errors.semester }}
                        </span>
                    </div>

                    <!-- SKS -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600">SKS</label>
                        <div class="flex gap-4">
                            <label>
                                <input
                                    v-model="sks"
                                    type="radio"
                                    name="sks"
                                    :value="2"
                                />
                                2 SKS
                            </label>
                            <label>
                                <input
                                    v-model="sks"
                                    type="radio"
                                    name="sks"
                                    :value="3"
                                />
                                3 SKS
                            </label>
                            <label>
                                <input
                                    v-model="sks"
                                    type="radio"
                                    name="sks"
                                    :value="4"
                                />
                                4 SKS
                            </label>
                        </div>
                        <span class="text-red-500 text-sm mt-1">
                            {{ errors.sks }}
                        </span>
                    </div>

                    <!-- Dosen Pengampu -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600"
                            >Dosen Pengampu</label
                        >
                        <select
                            v-model="dosen_id"
                            class="w-full px-5 py-2 bg-gray-200 rounded"
                        >
                            <option disabled value="">-- Pilih Dosen --</option>
                            <option
                                v-for="dosen in dosens"
                                :key="dosen.id"
                                :value="dosen.id"
                            >
                                {{ dosen.user.name }}
                            </option>
                        </select>
                        <span class="text-red-500 text-sm mt-1">
                            {{ errors.dosen_id }}
                        </span>
                    </div>

                    <!-- Kelas -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600">Kelas</label>
                        <input
                            type="text"
                            v-model="kelas"
                            class="w-full px-5 py-2 bg-gray-200 rounded"
                            readonly
                        />
                        <span class="text-red-500 text-sm mt-1">
                            {{ errors.kelas }}
                        </span>
                    </div>

                    <!-- Kapasitas -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600"
                            >Kapasitas Mahasiswa</label
                        >
                        <input
                            v-model="kapasitas"
                            type="number"
                            class="w-full px-5 py-2 bg-gray-200 rounded"
                        />
                        <span class="text-red-500 text-sm mt-1">
                            {{ errors.kapasitas }}
                        </span>
                    </div>

                    <!-- Hari & Jam -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600"
                            >Hari & Jam Kuliah</label
                        >
                        <div class="flex gap-4">
                            <!-- Pilih Hari -->
                            <div class="flex flex-col">
                                <select
                                    required
                                    name="hari"
                                    v-model="hari"
                                    class="px-4 py-2 bg-gray-200 rounded"
                                >
                                    <option disabled value="">
                                        -- Pilih Hari --
                                    </option>
                                    <option
                                        v-for="day in days"
                                        :key="day"
                                        :value="day"
                                    >
                                        {{ day }}
                                    </option>
                                    <span class="text-red-500 text-sm mt-1">
                                        {{ errors.hari }}
                                    </span>
                                </select>
                                <span class="text-red-500 text-sm mt-1">
                                    {{ errors.hari }}
                                </span>
                            </div>

                            <!-- Jam Mulai -->
                            <div class="flex flex-col">
                                <input
                                    v-model="jam_mulai"
                                    type="time"
                                    class="px-4 py-2 bg-gray-200 rounded"
                                />
                                <span class="text-red-500 text-sm mt-1">
                                    {{ errors.jam_mulai }}
                                </span>
                            </div>

                            <!-- Jam Selesai -->
                            <div class="flex flex-col">
                                <input
                                    v-model="jam_selesai"
                                    type="time"
                                    class="px-4 py-2 bg-gray-200 rounded"
                                />
                                <span class="text-red-500 text-sm mt-1">
                                    {{ errors.jam_selesai }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Ruangan -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600"
                            >Ruangan</label
                        >
                        <input
                            v-model="ruangan"
                            type="text"
                            class="w-full px-5 py-2 bg-gray-200 rounded"
                        />
                        <span class="text-red-500 text-sm mt-1">
                            {{ errors.ruangan }}
                        </span>
                    </div>

                    <!-- Submit -->
                    <div class="mt-6">
                        <button
                            type="submit"
                            class="px-4 py-2 text-white font-semibold bg-[#3d68ff] hover:bg-[#2d56d9] rounded"
                        >
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </AdminLayout>
</template>

<script setup>
import { useForm } from "vee-validate";
import * as yup from "yup";
import { router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

// props dari Laravel
const props = defineProps({
    dosens: {
        type: Array,
        required: true,
    },
});

const days = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];

// Schema validasi Yup
const schema = yup.object({
    kode: yup.string().required("Kode kuliah wajib diisi").min(1).max(14),
    nama: yup.string().required("Nama mata kuliah wajib diisi"),
    semester: yup.number().required("Semester wajib diisi").min(1).max(14),
    sks: yup.number().required("Jumlah SKS wajib diisi").min(1).max(6),
    dosen_id: yup.number().required("Dosen pengampu wajib dipilih"),
    kelas: yup.string().required("Kelas wajib diisi"),
    kapasitas: yup.number().required("Kapasitas wajib diisi").min(1),
    hari: yup.string().required("Hari wajib diisi"),
    jam_mulai: yup.string().required("Jam wajib diisi"),
    jam_selesai: yup.string().required("Jam wajib diisi"),
    ruangan: yup.string().required("Ruangan wajib diisi"),
});

const { handleSubmit, errors, defineField, isSubmitting } = useForm({
    validationSchema: schema,
    initialValues: {
        kelas: "KELAS A",
        hari: days[0],
    },
});

console.log(props);

const [kode] = defineField("kode", {
    validateOnModelUpdate: false,
});
const [nama] = defineField("nama", {
    validateOnModelUpdate: false,
});
const [semester] = defineField("semester", {
    validateOnModelUpdate: false,
});
const [sks] = defineField("sks", {
    validateOnModelUpdate: false,
});
const [dosen_id] = defineField("dosen_id", {
    validateOnModelUpdate: false,
});
const [kelas] = defineField("kelas", {
    validateOnModelUpdate: false,
});
const [kapasitas] = defineField("kapasitas", {
    validateOnModelUpdate: false,
});
const [hari] = defineField("hari", {
    validateOnModelUpdate: false,
});
const [jam_mulai] = defineField("jam_mulai", {
    validateOnModelUpdate: false,
});
const [jam_selesai] = defineField("jam_selesai", {
    validateOnModelUpdate: false,
});
const [ruangan] = defineField("ruangan", {
    validateOnModelUpdate: false,
});

// Submit handler
const submitForm = handleSubmit((values) => {
    isSubmitting.value = true;
    router.post("/matakuliah", values, {
        onSuccess: () => {
            isSubmitting.value = true;
        },
    });
});
</script>

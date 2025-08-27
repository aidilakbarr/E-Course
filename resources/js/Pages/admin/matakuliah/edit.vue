<template>
    <AdminLayout>
        <main class="w-full flex-grow p-6">
            <h1 class="text-3xl text-black pb-6">Edit Mata Kuliah</h1>

            <div class="w-full lg:w-1/2">
                <form
                    @submit.prevent="onSubmit"
                    class="p-10 bg-white rounded shadow-xl"
                >
                    <!-- kode Mata Kuliah -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600"
                            >Kode Mata Kuliah</label
                        >
                        <input
                            v-model="kode"
                            v-bind="kodeAttrs"
                            type="text"
                            class="w-full px-5 py-2 bg-gray-200 rounded"
                        />
                    </div>

                    <!-- Nama -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600"
                            >Nama Mata Kuliah</label
                        >
                        <input
                            v-model="nama"
                            v-bind="namaAttrs"
                            type="text"
                            class="w-full px-5 py-2 bg-gray-200 rounded"
                        />
                    </div>

                    <!-- Semester -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600"
                            >Semester</label
                        >
                        <select
                            v-model="semester"
                            v-bind="semesterAttrs"
                            class="w-full px-5 py-2 bg-gray-200 rounded"
                        >
                            <option v-for="i in 8" :key="i" :value="i">
                                Semester {{ i }}
                            </option>
                        </select>
                    </div>

                    <!-- SKS -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600">SKS</label>
                        <div class="flex gap-4">
                            <label v-for="s in [2, 3, 4]" :key="s">
                                <input
                                    type="radio"
                                    v-model="sks"
                                    v-bind="sksAttrs"
                                    :value="s"
                                />
                                {{ s }} SKS
                            </label>
                        </div>
                    </div>

                    <!-- Dosen -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600"
                            >Dosen Pengampu</label
                        >
                        <select
                            v-model="dosen_id"
                            v-bind="dosen_idAttrs"
                            class="w-full px-5 py-2 bg-gray-200 rounded"
                        >
                            <option disabled value="">-- Pilih Dosen --</option>
                            <option
                                v-for="dosen in props.dosens"
                                :key="dosen.id"
                                :value="dosen.id"
                            >
                                {{ dosen.user.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Kelas -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600">Kelas</label>
                        <input
                            v-model="kelas"
                            v-bind="kelasAttrs"
                            type="text"
                            class="w-full px-5 py-2 bg-gray-200 rounded"
                            readonly
                        />
                    </div>

                    <!-- Kapasitas -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600"
                            >Kapasitas Mahasiswa</label
                        >
                        <input
                            v-model="kapasitas"
                            v-bind="kapasitasAttrs"
                            type="number"
                            class="w-full px-5 py-2 bg-gray-200 rounded"
                        />
                    </div>

                    <!-- Hari & Jam -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600"
                            >Hari & Jam Kuliah</label
                        >
                        <div class="flex gap-4">
                            <select
                                v-model="hari"
                                v-bind="hariAttrs"
                                class="px-4 py-2 bg-gray-200 rounded"
                            >
                                <option
                                    v-for="day in hariList"
                                    :key="day"
                                    :value="day"
                                >
                                    {{ day }}
                                </option>
                            </select>
                            <input
                                type="time"
                                v-model="jam_mulai"
                                v-bind="jam_mulaiAttrs"
                                class="px-4 py-2 bg-gray-200 rounded"
                            />
                            <input
                                type="time"
                                v-model="jam_selesai"
                                v-bind="jam_selesaiAttrs"
                                class="px-4 py-2 bg-gray-200 rounded"
                            />
                        </div>
                        <span v-if="props.errors.hari" class="text-red-500">
                            {{ props.errors.hari }}
                        </span>
                    </div>

                    <!-- Ruangan -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600"
                            >Ruangan</label
                        >
                        <input
                            v-model="ruangan"
                            v-bind="ruanganAttrs"
                            type="text"
                            class="w-full px-5 py-2 bg-gray-200 rounded"
                        />
                    </div>

                    <!-- Submit -->
                    <div class="mt-6">
                        <button
                            type="submit"
                            id="submitBtn"
                            class="px-4 py-2 text-white font-semibold bg-yellow-500 hover:bg-yellow-600 rounded flex items-center justify-center gap-2"
                        >
                            <span class="ml-2" :disabled="isSubmitting">{{
                                isSubmitting ? "Loading..." : "Update"
                            }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </AdminLayout>
</template>

<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { useForm } from "vee-validate";
import * as yup from "yup";
import AdminLayout from "../../../Layouts/AdminLayout.vue";

const props = usePage().props;
console.log(props);
const hariList = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];

// schema vee-validate
const schema = yup.object({
    kode: yup.string().required("Kode wajib diisi"),
    nama: yup.string().required("Nama wajib diisi"),
    semester: yup.number().required(),
    sks: yup.number().oneOf([2, 3, 4]).required(),
    dosen_id: yup.number().required(),
    kapasitas: yup.number().min(1).required(),
    hari: yup.string().required(),
    jam_mulai: yup.string().required(),
    jam_selesai: yup
        .string()
        .required()
        .test("after", "Jam selesai harus setelah jam mulai", function (value) {
            return value > this.parent.jam_mulai;
        }),
    ruangan: yup.string().required(),
});

const { handleSubmit, values, defineField, isSubmitting, setErrors } = useForm({
    validationSchema: schema,
    initialValues: {
        kode: props.matakuliah.kode,
        nama: props.matakuliah.nama,
        semester: props.matakuliah.semester,
        sks: props.matakuliah.sks,
        dosen_id: props.matakuliah.dosen_id,
        kelas: "Kelas A",
        kapasitas: props.matakuliah.kapasitas,
        hari: props.matakuliah.hari,
        jam_mulai: props.matakuliah.jam_mulai,
        jam_selesai: props.matakuliah.jam_selesai,
        ruangan: props.matakuliah.ruangan,
    },
});

const [kode, kodeAttrs] = defineField("kode", { validateOnModelUpdate: false });
const [nama, namaAttrs] = defineField("nama", { validateOnModelUpdate: false });
const [semester, semesterAttrs] = defineField("semester", {
    validateOnModelUpdate: false,
});
const [sks, sksAttrs] = defineField("sks", { validateOnModelUpdate: false });
const [dosen_id, dosen_idAttrs] = defineField("dosen_id", {
    validateOnModelUpdate: false,
});
const [kelas, kelasAttrs] = defineField("kelas", {
    validateOnModelUpdate: false,
});
const [kapasitas, kapasitasAttrs] = defineField("kapasitas", {
    validateOnModelUpdate: false,
});
const [hari, hariAttrs] = defineField("hari", { validateOnModelUpdate: false });
const [jam_mulai, jam_mulaiAttrs] = defineField("jam_mulai", {
    validateOnModelUpdate: false,
});
const [jam_selesai, jam_selesaiAttrs] = defineField("jam_selesai", {
    validateOnModelUpdate: false,
});
const [ruangan, ruanganAttrs] = defineField("ruangan", {
    validateOnModelUpdate: false,
});

const onSubmit = handleSubmit((values) => {
    isSubmitting.value = true;
    router.put(`/matakuliah/${props.matakuliah.id}`, values, {
        onFinish: () => console.log(props),
    });
});
</script>

<template>
    <AdminLayout>
        <main class="w-full flex-grow p-6">
            <h1 class="w-full text-3xl text-black pb-6">Forms</h1>

            <div class="flex flex-wrap">
                <div class="w-full lg:w-1/2 my-6 pr-0 lg:pr-2">
                    <p class="text-xl pb-6 flex items-center">
                        <i class="fas fa-user-plus mr-3"></i> Add User
                    </p>
                    <div class="leading-loose">
                        <form
                            @submit.prevent="onSubmit"
                            class="p-10 bg-white rounded shadow-xl"
                        >
                            <div class="mb-4">
                                <label
                                    class="block text-sm text-gray-600"
                                    for="add-profile_url"
                                    >Profile Photo</label
                                >
                                <input
                                    type="file"
                                    class="w-full px-5 py-2 bg-gray-200 rounded"
                                />
                                <p class="text-sm text-red-500 mt-1">
                                    {{ errors.photo }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <label
                                    class="block text-sm text-gray-600"
                                    for="add-name"
                                    >Name</label
                                >
                                <input
                                    type="text"
                                    class="w-full px-5 py-2 bg-gray-200 rounded"
                                    required
                                    v-model="name"
                                />
                                <p class="text-sm text-red-500 mt-1">
                                    {{ errors.name }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <label
                                    class="block text-sm text-gray-600"
                                    for="add-email"
                                    >Email</label
                                >
                                <input
                                    type="email"
                                    class="w-full px-5 py-2 bg-gray-200 rounded"
                                    required
                                    v-model="email"
                                />
                                <p class="text-sm text-red-500 mt-1">
                                    {{ errors.email }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <label
                                    class="block text-sm text-gray-600"
                                    for="add-password"
                                    >Password</label
                                >
                                <input
                                    type="password"
                                    class="w-full px-5 py-2 bg-gray-200 rounded"
                                    required
                                    v-model="password"
                                />
                                <p class="text-sm text-red-500 mt-1">
                                    {{ errors.password }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <label
                                    class="block text-sm text-gray-600"
                                    for="add-role"
                                    >Role</label
                                >
                                <select
                                    name="role"
                                    class="w-full px-5 py-2 bg-gray-200 rounded"
                                    required
                                    v-model="role"
                                >
                                    <option value="MAHASISWA">MAHASISWA</option>
                                    <option value="DOSEN">DOSEN</option>
                                    <option value="KAPRODI">KAPRODI</option>
                                </select>
                                <p class="text-sm text-red-500 mt-1">
                                    {{ errors.role }}
                                </p>
                            </div>

                            <div v-if="role === 'MAHASISWA'">
                                <div class="mb-4">
                                    <label class="block text-sm text-gray-600"
                                        >NIM</label
                                    >
                                    <input
                                        type="text"
                                        class="w-full px-5 py-2 bg-gray-200 rounded"
                                        v-model="nim"
                                    />
                                    <p class="text-sm text-red-500 mt-1">
                                        {{ errors.nim }}
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm text-gray-600"
                                        >Program Studi</label
                                    >
                                    <input
                                        type="text"
                                        class="w-full px-5 py-2 bg-gray-200 rounded"
                                        v-model="prodi_mahasiswa"
                                    />
                                    <p class="text-sm text-red-500 mt-1">
                                        {{ errors.prodi_mahasiswa }}
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm text-gray-600"
                                        >Angkatan</label
                                    >
                                    <input
                                        type="text"
                                        class="w-full px-5 py-2 bg-gray-200 rounded"
                                        v-model="angkatan"
                                    />
                                    <p class="text-sm text-red-500 mt-1">
                                        {{ errors.angkatan }}
                                    </p>
                                </div>
                            </div>

                            <div v-if="role === 'DOSEN'">
                                <div class="mb-4">
                                    <label class="block text-sm text-gray-600"
                                        >NIDN</label
                                    >
                                    <input
                                        type="text"
                                        class="w-full px-5 py-2 bg-gray-200 rounded"
                                        v-model="nidn"
                                    />
                                    <p class="text-sm text-red-500 mt-1">
                                        {{ errors.nidn }}
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm text-gray-600"
                                        >Program Studi</label
                                    >
                                    <input
                                        type="text"
                                        class="w-full px-5 py-2 bg-gray-200 rounded"
                                        v-model="prodi"
                                    />
                                    <p class="text-sm text-red-500 mt-1">
                                        {{ errors.prodi }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button
                                    type="submit"
                                    id="submitBtn"
                                    class="px-4 py-2 text-white font-semibold bg-[#3d68ff] hover:bg-[#2d56d9] rounded flex items-center justify-center gap-2"
                                >
                                    <span id="submitText">Submit</span>
                                    <span
                                        id="submitLoading"
                                        class="hidden animate-spin border-t-2 border-white border-solid rounded-full h-4 w-4"
                                    ></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </AdminLayout>
</template>
<script setup>
import { useForm } from "vee-validate";
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { router, usePage } from "@inertiajs/vue3";
import * as yup from "yup";

const schema = yup.object({
    name: yup
        .string()
        .required("Nama wajib diisi")
        .min(3, "Minimal 3 karakter"),
    email: yup
        .string()
        .required("Email wajib diisi")
        .email("Format email tidak valid"),
    password: yup
        .string()
        .required("Password wajib diisi")
        .min(6, "Minimal 6 karakter"),
    role: yup
        .string()
        .oneOf(["ADMIN", "MAHASISWA", "KAPRODI", "DOSEN"], "Role tidak valid")
        .required("Role wajib diisi"),
    profile: yup.mixed(),

    nim: yup.string().when("role", {
        is: "MAHASISWA",
        then: (schema) => schema.required("NIM wajib diisi"),
    }),
    prodi_mahasiswa: yup.string().when("role", {
        is: "MAHASISWA",
        then: (schema) => schema.required("Prodi wajib diisi"),
    }),
    angkatan: yup.string().when("role", {
        is: "MAHASISWA",
        then: (schema) => schema.required("Angkatan wajib diisi"),
    }),

    nidn: yup.string().when("role", {
        is: "DOSEN",
        then: (schema) => schema.required("NIDN wajib diisi"),
    }),
    prodi: yup.string().when("role", {
        is: "DOSEN",
        then: (schema) => schema.required("Prodi wajib diisi"),
    }),
});

const { values, handleSubmit, errors, defineField, isSubmitting } = useForm({
    validationSchema: schema,
});

const [name] = defineField("name", {
    validateOnModelUpdate: false,
});
const [email] = defineField("email", {
    validateOnModelUpdate: false,
});
const [password] = defineField("password", {
    validateOnModelUpdate: false,
});
const [role] = defineField("role", {
    validateOnModelUpdate: false,
});
const [profile] = defineField("profile", {
    validateOnModelUpdate: false,
});
const [nim] = defineField("nim");
const [prodi_mahasiswa] = defineField("prodi_mahasiswa");
const [angkatan] = defineField("angkatan");

const [nidn] = defineField("nidn");
const [prodi] = defineField("prodi");

const onSubmit = handleSubmit((values) => {
    isSubmitting.value = true;
    router.post("/users", values, {
        onFinish: () => (isSubmitting.value = false),
    });
});
</script>

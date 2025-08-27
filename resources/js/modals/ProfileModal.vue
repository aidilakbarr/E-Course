<template>
    <div
        v-if="show"
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
    >
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <div class="text-center mb-4">
                <input
                    ref="fileInput"
                    type="file"
                    accept="image/*"
                    class="hidden"
                    @change="handleFileChange"
                />

                <img
                    v-if="previewImage || user?.profile"
                    :src="previewImage || `/storage/${user.profile}`"
                    alt="Profile Picture"
                    class="w-24 h-24 rounded-full mx-auto object-cover cursor-pointer"
                    @click="triggerFileInput"
                />

                <div
                    v-else
                    class="w-24 h-24 rounded-full bg-gray-200 mx-auto flex items-center justify-center cursor-pointer"
                    @click="triggerFileInput"
                >
                    <i class="fas fa-user text-3xl text-gray-500"></i>
                </div>

                <h2 class="text-xl font-semibold mt-3">Edit Profil</h2>
            </div>

            <form @submit.prevent="updateProfile" class="space-y-3">
                <div>
                    <label class="block text-sm font-medium">Nama</label>
                    <input
                        v-model="name"
                        type="text"
                        class="w-full border rounded p-2"
                    />
                    <span class="text-red-500 text-sm">{{ errors.name }}</span>
                </div>

                <div>
                    <label class="block text-sm font-medium">Email</label>
                    <input
                        v-model="email"
                        type="email"
                        class="w-full border rounded p-2"
                    />
                    <span class="text-red-500 text-sm">{{ errors.email }}</span>
                </div>

                <div>
                    <label class="block text-sm font-medium">Password</label>
                    <input
                        v-model="password"
                        type="password"
                        class="w-full border rounded p-2"
                        placeholder="Kosongkan jika tidak ingin ubah"
                    />
                    <span class="text-red-500 text-sm">{{
                        errors.password
                    }}</span>
                </div>

                <div class="flex justify-end space-x-2">
                    <button
                        type="button"
                        @click="close"
                        class="px-4 py-2 bg-gray-300 rounded"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded"
                    >
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { useForm, useField } from "vee-validate";
import * as yup from "yup";
import { ref, watch } from "vue";
const emit = defineEmits(["update", "close"]);
const fileInput = ref(null);
const previewImage = ref(null);

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    user: {
        type: Object,
        required: true,
    },
});

const schema = yup.object({
    name: yup.string().required("Nama wajib diisi"),
    email: yup
        .string()
        .email("Email tidak valid")
        .required("Email wajib diisi"),
    password: yup.string().nullable(),
    profile: yup.mixed().nullable(),
});

const { handleSubmit, errors, resetForm, setFieldValue } = useForm({
    validationSchema: schema,
    initialValues: {
        name: props.user.name,
        email: props.user.email,
        password: "",
        profile: null,
    },
});

const { value: name } = useField("name");
const { value: email } = useField("email");
const { value: password } = useField("password");

const close = () => {
    emit("close");
    console.log(props.user);
};

const triggerFileInput = () => {
    fileInput.value.click();
};

const handleFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        setFieldValue("profile", file);
        previewImage.value = URL.createObjectURL(file);
    }
};

const updateProfile = handleSubmit((values) => {
    emit("update", values);
    resetForm();
    emit("close");
});

watch(
    () => props.show,
    (isOpen) => {
        if (isOpen && props.user) {
            resetForm({
                values: {
                    name: props.user.name,
                    email: props.user.email,
                    password: "",
                    profile: null,
                },
            });
        }
    }
);
</script>

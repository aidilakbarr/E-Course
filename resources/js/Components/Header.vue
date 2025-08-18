<template>
    <!-- Desktop Header -->
    <header class="w-full items-center bg-white py-2 px-6 hidden sm:flex">
        <div class="w-1/2"></div>

        <div class="relative w-1/2 flex justify-end">
            <div class="flex items-center h-12 font-bold px-4">
                <span>{{ authUser.name }}</span>
            </div>

            <div class="relative">
                <button
                    @click="isOpen = !isOpen"
                    class="relative z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none"
                >
                    <!-- <img :src="authUser.profile" alt="User Profile" /> -->
                </button>

                <div
                    v-if="isOpen"
                    @click.self="isOpen = false"
                    class="absolute right-0 w-32 bg-white rounded-lg shadow-lg py-2 mt-2 z-50 transition-all duration-200"
                >
                    <button
                        @click="isProfileOpen = !isProfileOpen"
                        class="text-center w-full py-2 hover:bg-blue-500 hover:text-white account-link"
                    >
                        Profile
                    </button>
                    <button
                        :disabled="loading"
                        @click="handleLogout"
                        class="text-center w-full py-2 account-link hover:bg-red-500 hover:text-white"
                    >
                        {{ loading ? "Logging out..." : "Logout" }}
                    </button>
                </div>
            </div>
        </div>
    </header>
</template>

<script setup>
import { ref, watch } from "vue";
import { router, usePage } from "@inertiajs/vue3";

const isOpen = ref(false);
const isProfileOpen = ref(false);

const authUser = usePage().props.authUser;

const loading = ref(false);
// watch(
//     () => page.props.flash,
//     (newFlash) => {
//         // Tambahkan kondisi untuk memastikan newFlash tidak undefined
//         if (newFlash) {
//             // Periksa apakah ada pesan 'success'
//             if (newFlash.success) {
//                 Swal.fire({
//                     icon: "success",
//                     title: "Berhasil!",
//                     text: newFlash.success,
//                     showConfirmButton: false,
//                     timer: 3000,
//                 });
//             }

//             // Periksa apakah ada pesan 'error'
//             if (newFlash.error) {
//                 Swal.fire({
//                     icon: "error",
//                     title: "Gagal!",
//                     text: newFlash.error,
//                     showConfirmButton: false,
//                     timer: 3000,
//                 });
//             }
//         }
//     },
//     { deep: true }
// );

const handleLogout = () => {
    loading.value = true;

    router.post(
        "/auth/logout",
        {},
        {
            onSuccess: (page) => {
                Swal.fire({
                    title: "Sukses!",
                    text: "Berhasil logout",
                    icon: "success",
                    timer: 2500,
                });
            },
            onError: (errors) => {
                Swal.fire({
                    title: "Error!",
                    text: "Terjadi kesalahan saat logout.",
                    icon: "error",
                    timer: 2500,
                });
                console.error(errors);
            },
            onFinish: () => {
                loading.value = false;
            },
        }
    );
};
</script>

<style scoped></style>

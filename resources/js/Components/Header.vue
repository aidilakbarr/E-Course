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
                    <img
                        :src="`/storage/${authUser.profile}`"
                        alt="User Profile"
                    />
                </button>

                <div
                    v-if="isOpen"
                    @click.self="isOpen = false"
                    class="absolute right-0 w-32 bg-white rounded-lg shadow-lg py-2 mt-2 z-50 transition-all duration-200"
                >
                    <button
                        @click="openProfile()"
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
    <ProfileModal
        :show="showModal"
        :user="selectedUser"
        @close="showModal = false"
        @update="handleUpdateProfile"
    />
</template>

<script setup>
import { ref, watch } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import ProfileModal from "../modals/ProfileModal.vue";

const isOpen = ref(false);
const showModal = ref(false);
const selectedUser = ref({});
const authUser = usePage().props.authUser;

const loading = ref(false);

const openProfile = () => {
    selectedUser.value = authUser;
    showModal.value = true;
    console.log(selectedUser);
};

const handleUpdateProfile = (data) => {
    console.log("Data : ", data);
    router.post("edit-user", data);
};

const handleLogout = () => {
    loading.value = true;

    console.log();

    router.post("/auth/logout");
};
</script>

<style scoped></style>

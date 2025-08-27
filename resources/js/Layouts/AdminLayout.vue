<template>
    <div class="bg-gray-100 font-family-karla flex">
        <SidebarComponent />
        <div class="w-full flex flex-col h-screen overflow-y-hidden">
            <HeaderComponent />
            <div class="w-full overflow-x-hidden border-t flex flex-col">
                <main class="w-full flex-grow p-6">
                    <div
                        class="w-full overflow-x-hidden flex flex-col lg:flex-row"
                    >
                        <main class="w-full flex-grow p-6">
                            <slot />
                        </main>
                    </div>

                    <div
                        x-data="{ open: false }"
                        x-cloak
                        x-show="open"
                        x-transition
                        id="modal-wrapper"
                        @open-modal.window="open = true"
                        @close-modal.window="open = false"
                        class="fixed inset-0 z-50 bg-opacity-50 flex items-center justify-center"
                    >
                        <div
                            @click="open = false"
                            class="fixed inset-0 bg-gray-500/75 transition-opacity"
                            aria-hidden="true"
                        ></div>
                        <div
                            class="relative z-10 bg-white rounded-lg shadow-xl sm:max-w-lg w-full mx-4 sm:mx-0"
                            @click.away="open = false"
                            x-transition
                        >
                            <form
                                method="POST"
                                id="modal-form"
                                class="bg-white p-6 rounded shadow w-full max-w-md"
                            >
                                <h2
                                    id="modal-title"
                                    class="text-xl font-semibold mb-4"
                                >
                                    Hapus Course
                                </h2>
                                <p
                                    id="modal-message"
                                    class="mb-6 text-gray-700"
                                >
                                    Apakah kamu yakin ingin menghapus course
                                    ini?
                                </p>
                                <div class="flex justify-end gap-3">
                                    <button
                                        type="button"
                                        class="px-4 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-100"
                                        @click="open = false"
                                    >
                                        Batal
                                    </button>
                                    <button
                                        type="button"
                                        id="modal-button"
                                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
                                        @click="confirmDelete()"
                                    >
                                        Hapus
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>

<script setup>
import HeaderComponent from "@/Components/Header.vue";
import SidebarComponent from "../Components/Sidebar.vue";
import { usePage } from "@inertiajs/vue3";
import { watch } from "vue";

const page = usePage();

watch(
    () => page.props.flash,
    (flash) => {
        if (flash.success) {
            Swal.fire({
                icon: "success",
                title: "Berhasil",
                text: flash.success,
                timer: 2000,
                showConfirmButton: false,
            });
        }

        if (flash.error) {
            Swal.fire({
                icon: "error",
                title: "Gagal",
                text: flash.error,
            });
        }
    },
    { deep: true }
);
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css?family=Karla:400,700&display=swap");

.font-family-karla {
    font-family: karla;
}

.bg-sidebar {
    background: #3d68ff;
}

.cta-btn {
    color: #3d68ff;
}

.upgrade-btn {
    background: #1947ee;
}

.upgrade-btn:hover {
    background: #0038fd;
}

.active-nav-link {
    background: #1947ee;
}

.nav-item:hover {
    background: #1947ee;
}

.account-link:hover {
    background: #3d68ff;
}

[x-cloak] {
    display: none !important;
}
</style>

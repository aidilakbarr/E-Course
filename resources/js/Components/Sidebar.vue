<template>
    <aside
        v-show="sidebarVisible"
        class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl"
    >
        <div class="p-6">
            <Link
                href="/"
                class="text-white text-3xl font-semibold uppercase hover:text-gray-300"
            >
                {{ userRole }}
            </Link>
        </div>

        <nav class="text-white text-base font-semibold pt-3">
            <Link
                href="/dashboard"
                :class="[
                    'flex items-center py-2 px-4',
                    isActive('/dashboard')
                        ? 'active-nav-link'
                        : 'opacity-75 hover:opacity-100',
                ]"
            >
                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
            </Link>

            <Link
                v-if="userRole === 'ADMIN'"
                href="/users"
                :class="[
                    'flex items-center py-2 px-4',
                    isActive('/users')
                        ? 'active-nav-link'
                        : 'opacity-75 hover:opacity-100',
                ]"
            >
                <i class="fas fa-users mr-2"></i> Manajemen Pengguna
            </Link>

            <div
                class="relative"
                :class="[
                    akademikOpen
                        ? 'opacity-100'
                        : 'opacity-75 hover:opacity-100',
                ]"
            >
                <button
                    @click="akademikOpen = !akademikOpen"
                    class="flex items-center w-full py-2 px-4 text-left focus:outline-none"
                >
                    <i class="fas fa-book mr-2"></i> Akademik
                    <svg
                        class="w-4 h-4 ml-auto"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19 9l-7 7-7-7"
                        />
                    </svg>
                </button>

                <ul
                    v-show="akademikOpen"
                    class="absolute left-0 mt-2 w-56 bg-white border border-gray-200 rounded-md shadow-lg z-10"
                >
                    <li>
                        <Link
                            :href="
                                userRole === 'ADMIN'
                                    ? '/matakuliah'
                                    : '/krs/set_krs_mhs'
                            "
                            :class="[
                                'block text-black px-4 py-2 hover:bg-gray-100',
                                isActive(
                                    userRole === 'ADMIN'
                                        ? '/matakuliah'
                                        : '/krs/set_krs_mhs'
                                )
                                    ? 'bg-gray-200 font-bold'
                                    : '',
                            ]"
                        >
                            {{
                                userRole === "ADMIN"
                                    ? "Mata Kuliah"
                                    : "Penawaran KRS"
                            }}
                        </Link>
                    </li>
                    <li v-if="userRole === 'ADMIN'">
                        <Link
                            href="/krs/submitted"
                            :class="[
                                'block text-black px-4 py-2 hover:bg-gray-100',
                                isActive('/krs/submitted')
                                    ? 'bg-gray-200 font-bold'
                                    : '',
                            ]"
                        >
                            Krs Mahasiswa
                        </Link>
                    </li>
                    K
                </ul>
            </div>

            <Link
                v-if="userRole === 'ADMIN'"
                href="/laporan"
                :class="[
                    'flex items-center py-2 px-4',
                    isActive('/laporan')
                        ? 'active-nav-link'
                        : 'opacity-75 hover:opacity-100',
                ]"
            >
                <i class="fas fa-chart-line mr-2"></i> Laporan Sistem
            </Link>
        </nav>

        <Link
            href="#"
            class="absolute w-full upgrade-btn bottom-0 active-nav-link text-white flex items-center justify-center py-4"
        >
            Dashboard V1.0.0
        </Link>
    </aside>
</template>

<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { useActive } from "../composables/useActive";

const page = usePage();
const userRole = computed(() => page.props.authUser?.role ?? null);

const akademikOpen = ref(false);
const sidebarVisible = ref(true);

const isActive = useActive();
</script>

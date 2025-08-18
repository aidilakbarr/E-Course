<template>
    <AdminLayout>
        <main class="w-full min-h-screen transition-all main">
            <!-- Content -->
            <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6"
            >
                <div
                    class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5"
                >
                    <div class="flex justify-between mb-6">
                        <div>
                            <div class="flex items-center mb-1">
                                <div class="text-2xl font-semibold">100</div>
                                <div
                                    class="p-1 rounded bg-emerald-500/10 text-emerald-500 text-[12px] font-semibold leading-none ml-2"
                                >
                                    +30%
                                </div>
                            </div>
                            <div class="text-sm font-medium text-gray-400">
                                Total Kursus
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5"
                >
                    <div class="flex justify-between mb-6">
                        <div>
                            <div class="flex items-center mb-1">
                                <div class="text-2xl font-semibold">100</div>
                                <div
                                    class="p-1 rounded bg-emerald-500/10 text-emerald-500 text-[12px] font-semibold leading-none ml-2"
                                >
                                    +30%
                                </div>
                            </div>
                            <div class="text-sm font-medium text-gray-400">
                                Total Users
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5"
                >
                    <div class="flex justify-between mb-4">
                        <div>
                            <div class="flex items-center mb-1">
                                <div class="text-2xl font-semibold">100</div>
                                <div
                                    class="p-1 rounded bg-emerald-500/10 text-emerald-500 text-[12px] font-semibold leading-none ml-2"
                                >
                                    +30%
                                </div>
                            </div>
                            <div class="text-sm font-medium text-gray-400">
                                Total Pendaftaran
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5"
                >
                    <div class="flex justify-between mb-6">
                        <div>
                            <div class="flex items-center mb-1">
                                <div class="text-2xl font-semibold">100</div>
                                <div
                                    class="p-1 rounded bg-emerald-500/10 text-emerald-500 text-[12px] font-semibold leading-none ml-2"
                                >
                                    +30%
                                </div>
                            </div>
                            <div class="text-sm font-medium text-gray-400">
                                Pendaftaran minggu ini
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div
                    class="p-6 relative flex flex-col min-w-0 mb-4 lg:mb-0 break-words bg-gray-50 dark:bg-gray-800 w-full shadow-lg rounded"
                >
                    <div class="rounded-t mb-0 px-0 border-0">
                        <div class="flex flex-wrap items-center px-4 py-2">
                            <div
                                class="relative w-full max-w-full flex-grow flex-1"
                            >
                                <h3
                                    class="font-semibold text-base text-gray-900 dark:text-gray-50"
                                >
                                    Kursus Terpopuler
                                </h3>
                            </div>
                        </div>
                        <div class="block w-full overflow-x-auto">
                            <table
                                class="items-center w-full bg-transparent border-collapse"
                            >
                                <thead>
                                    <tr>
                                        <th
                                            class="px-4 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-100 align-middle border border-solid border-gray-200 dark:border-gray-500 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
                                        >
                                            Judul
                                        </th>
                                        <th
                                            class="px-4 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-100 align-middle border border-solid border-gray-200 dark:border-gray-500 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
                                        >
                                            Jumlah Pendaftaran
                                        </th>
                                        <th
                                            class="px-4 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-100 align-middle border border-solid border-gray-200 dark:border-gray-500 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left min-w-140-px"
                                        ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        class="text-gray-700 dark:text-gray-100"
                                    >
                                        <th
                                            class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left"
                                        >
                                            Administrator
                                        </th>
                                        <td
                                            class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
                                        >
                                            1
                                        </td>
                                        <td
                                            class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
                                        >
                                            <div class="flex items-center">
                                                <span class="mr-2">70%</span>
                                                <div class="relative w-full">
                                                    <div
                                                        class="overflow-hidden h-2 text-xs flex rounded bg-blue-200"
                                                    >
                                                        <div
                                                            style="width: 70%"
                                                            class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-600"
                                                        ></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr
                                        class="text-gray-700 dark:text-gray-100"
                                    >
                                        <th
                                            class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left"
                                        >
                                            User
                                        </th>
                                        <td
                                            class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
                                        >
                                            6
                                        </td>
                                        <td
                                            class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
                                        >
                                            <div class="flex items-center">
                                                <span class="mr-2">40%</span>
                                                <div class="relative w-full">
                                                    <div
                                                        class="overflow-hidden h-2 text-xs flex rounded bg-blue-200"
                                                    >
                                                        <div
                                                            style="width: 40%"
                                                            class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"
                                                        ></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr
                                        class="text-gray-700 dark:text-gray-100"
                                    >
                                        <th
                                            class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left"
                                        >
                                            User
                                        </th>
                                        <td
                                            class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
                                        >
                                            5
                                        </td>
                                        <td
                                            class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
                                        >
                                            <div class="flex items-center">
                                                <span class="mr-2">45%</span>
                                                <div class="relative w-full">
                                                    <div
                                                        class="overflow-hidden h-2 text-xs flex rounded bg-pink-200"
                                                    >
                                                        <div
                                                            style="width: 45%"
                                                            class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-pink-500"
                                                        ></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr
                                        class="text-gray-700 dark:text-gray-100"
                                    >
                                        <th
                                            class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left"
                                        >
                                            User
                                        </th>
                                        <td
                                            class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
                                        >
                                            4
                                        </td>
                                        <td
                                            class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
                                        >
                                            <div class="flex items-center">
                                                <span class="mr-2">60%</span>
                                                <div class="relative w-full">
                                                    <div
                                                        class="overflow-hidden h-2 text-xs flex rounded bg-red-200"
                                                    >
                                                        <div
                                                            style="width: 60%"
                                                            class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-500"
                                                        ></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md"
                >
                    <div class="flex justify-between mb-4 items-start">
                        <div class="font-medium">
                            Pendaftaran Course Terbaru
                        </div>
                    </div>
                    <div class="overflow-hidden">
                        <table class="w-full min-w-[540px]">
                            <tbody>
                                <tr>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <div class="flex items-center">
                                            <a
                                                href="#"
                                                class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate"
                                                >Aidil Akbar</a
                                            >
                                        </div>
                                    </td>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <span
                                            class="text-[13px] font-medium text-gray-400"
                                            >02-02-2024</span
                                        >
                                    </td>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <span
                                            class="text-[13px] font-medium text-gray-400"
                                            >17.45</span
                                        >
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <div class="flex items-center">
                                            <a
                                                href="#"
                                                class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate"
                                                >Lorem Ipsum</a
                                            >
                                        </div>
                                    </td>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <span
                                            class="text-[13px] font-medium text-gray-400"
                                            >02-02-2024</span
                                        >
                                    </td>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <span
                                            class="text-[13px] font-medium text-gray-400"
                                            >17.45</span
                                        >
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <div class="flex items-center">
                                            <a
                                                href="#"
                                                class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate"
                                                >Lorem Ipsum</a
                                            >
                                        </div>
                                    </td>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <span
                                            class="text-[13px] font-medium text-gray-400"
                                            >02-02-2024</span
                                        >
                                    </td>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <span
                                            class="text-[13px] font-medium text-gray-400"
                                            >17.45</span
                                        >
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <div class="flex items-center">
                                            <a
                                                href="#"
                                                class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate"
                                                >Lorem Ipsum</a
                                            >
                                        </div>
                                    </td>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <span
                                            class="text-[13px] font-medium text-gray-400"
                                            >02-02-2024</span
                                        >
                                    </td>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <span
                                            class="text-[13px] font-medium text-gray-400"
                                            >17.45</span
                                        >
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <div class="flex items-center">
                                            <a
                                                href="#"
                                                class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate"
                                                >Lorem Ipsum</a
                                            >
                                        </div>
                                    </td>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <span
                                            class="text-[13px] font-medium text-gray-400"
                                            >02-02-2024</span
                                        >
                                    </td>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <span
                                            class="text-[13px] font-medium text-gray-400"
                                            >17.45</span
                                        >
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <div class="flex items-center">
                                            <a
                                                href="#"
                                                class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate"
                                                >Lorem Ipsum</a
                                            >
                                        </div>
                                    </td>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <span
                                            class="text-[13px] font-medium text-gray-400"
                                            >02-02-2024</span
                                        >
                                    </td>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <span
                                            class="text-[13px] font-medium text-gray-400"
                                            >17.45</span
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <div
                    class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md lg:col-span-2"
                >
                    <div class="flex justify-between mb-4 items-start">
                        <div class="font-medium">Pendaftaran Statistics</div>
                    </div>
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4"
                    >
                        <div
                            class="rounded-md border border-dashed border-gray-200 p-4"
                        >
                            <div class="flex items-center mb-0.5">
                                <div class="text-xl font-semibold">10</div>
                            </div>
                            <span class="text-gray-400 text-sm"
                                >Total Pendaftaran</span
                            >
                        </div>
                        <div
                            class="rounded-md border border-dashed border-gray-200 p-4"
                        >
                            <div class="flex items-center mb-0.5">
                                <div class="text-xl font-semibold">50</div>
                            </div>
                            <span class="text-gray-400 text-sm"
                                >Pendaftaran selesai</span
                            >
                        </div>
                        <div
                            class="rounded-md border border-dashed border-gray-200 p-4"
                        >
                            <div class="flex items-center mb-0.5">
                                <div class="text-xl font-semibold">4</div>
                            </div>
                            <span class="text-gray-400 text-sm"
                                >Pendaftaran dibatalan</span
                            >
                        </div>
                    </div>
                    <div>
                        <canvas id="order-chart"></canvas>
                    </div>
                </div>
                <div
                    class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md"
                >
                    <div class="flex justify-between mb-4 items-start">
                        <div class="font-medium">Pendapatan</div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[460px]">
                            <thead>
                                <tr>
                                    <th
                                        class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tl-md rounded-bl-md"
                                    >
                                        Title
                                    </th>
                                    <th
                                        class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left"
                                    >
                                        Earning
                                    </th>
                                    <th
                                        class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tr-md rounded-br-md"
                                    >
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <div class="flex items-center">
                                            <img
                                                src="https://placehold.co/32x32"
                                                alt=""
                                                class="w-8 h-8 rounded object-cover block"
                                            />
                                            <a
                                                href="#"
                                                class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate"
                                                >Belajar python</a
                                            >
                                        </div>
                                    </td>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <span
                                            class="text-[13px] font-medium text-emerald-500"
                                            >+$235</span
                                        >
                                    </td>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <span
                                            class="inline-block p-1 rounded bg-emerald-500/10 text-emerald-500 font-medium text-[12px] leading-none"
                                            >Pending</span
                                        >
                                    </td>
                                </tr>

                                <tr>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <div class="flex items-center">
                                            <img
                                                src="https://placehold.co/32x32"
                                                alt=""
                                                class="w-8 h-8 rounded object-cover block"
                                            />
                                            <a
                                                href="#"
                                                class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate"
                                                >Belajar Javascript
                                            </a>
                                        </div>
                                    </td>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <span
                                            class="text-[13px] font-medium text-rose-500"
                                            >-$235</span
                                        >
                                    </td>
                                    <td
                                        class="py-2 px-4 border-b border-b-gray-50"
                                    >
                                        <span
                                            class="inline-block p-1 rounded bg-rose-500/10 text-rose-500 font-medium text-[12px] leading-none"
                                            >Withdrawn</span
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
</script>

<style></style>

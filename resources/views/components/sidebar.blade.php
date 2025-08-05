<aside id="sidebar" class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl" style="display: none;">
    <div class="p-6">
        <a href="/" class="text-white text-3xl font-semibold uppercase hover:text-gray-300" id="role"></a>
    </div>

    <nav class="text-white text-base font-semibold pt-3" id="sidebar-nav">
        <x-nav-link href="#" icon="fa-tachometer-alt" :active="false" id="nav-dashboard"></x-nav-link>
        <x-nav-link href="#" icon="fa-users" :active="false" id="nav-users"></x-nav-link>
        <x-nav-link href="#" icon="fa-book" :active="false" id="nav-matakuliah"></x-nav-link>
        <x-nav-link href="#" icon="fa-chart-line" :active="false" id="nav-laporan"></x-nav-link>
    </nav>

    <a href="#"
        class="absolute w-full upgrade-btn bottom-0 active-nav-link text-white flex items-center justify-center py-4">
        Dashboard V1.0.0
    </a>
</aside>


<script type="module">
    import {
        UserStore
    } from '/js/userStore.js';
    document.addEventListener("DOMContentLoaded", async () => {
        const sidebar = document.getElementById("sidebar");

        try {
            const user = await UserStore.load();

            const role = document.getElementById("role");
            role.innerHTML = `${user.role}`;

            const dashboard = document.getElementById("nav-dashboard");
            dashboard.href = "/dashboard";
            dashboard.innerHTML = `<i class="fas fa-tachometer-alt mr-2"></i> Dashboard`;

            const users = document.getElementById("nav-users");
            if (user.role === 'ADMIN') {
                users.href = "/users";
                users.innerHTML = `<i class="fas fa-users mr-2"></i> Manajemen Pengguna`;
            } else {
                users.style.display = "none";
            }

            const navLectures = document.getElementById("nav-matakuliah");
            navLectures.innerHTML = `
<li x-data="{ open: false }" class="relative list-none">
    <!-- Trigger -->
    <button @click="open = !open"
        class="flex items-center w-full py-2 text-left focus:outline-none">
        <i class="fas fa-book mr-2"></i>Lectures
        <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <ul x-show="open" @click.away="open = false" x-transition
        class="absolute left-0 mt-2 w-56 bg-white border border-gray-200 rounded-md shadow-lg z-10">
        <li><a href="/matakuliah" class="block text-black px-4 py-2 hover:bg-gray-100">Mata kuliah</a></li>
        <li><a href="/matakuliah" class="block text-black px-4 py-2 hover:bg-gray-100">Dosen Pengampu</a></li>
    </ul>
</li>

`;
            navLectures.classList.add("relative", "group");

            const laporan = document.getElementById("nav-laporan");
            if (user.role === 'ADMIN') {
                laporan.href = "/laporan";
                laporan.innerHTML = `<i class="fas fa-chart-line mr-2"></i> Laporan Sistem`;
            } else {
                laporan.style.display = "none";
            }

            sidebar.style.display = "block";
        } catch (error) {
            console.error("Gagal memuat sidebar:", error);
        }
    });
</script>

<!-- Desktop Header -->
<header class="w-full items-center bg-white py-2 px-6 hidden sm:flex">
    <div class="w-1/2"></div>
    <div x-data="{ isOpen: false, isProfileOpen: false }" class="relative w-1/2 flex justify-end">
        <div class="flex items-center h-12 font-bold px-4">
            <span id="user-name">Loading...</span>
        </div>

        <div class="relative">
            <button @click="isOpen = !isOpen"
                class="relative z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none">
                <img id="profile-image" src="/images/default-profile.png" alt="User Profile">
            </button>

            <div x-show="isOpen" @click.outside="isOpen = false"
                class="absolute right-0 w-32 bg-white rounded-lg shadow-lg py-2 mt-2 z-50 transition-all duration-200">
                <button @click="isProfileOpen = !isProfileOpen"
                    class="text-center w-full py-2 hover:bg-blue-500 hover:text-white account-link">
                    Profile
                </button>
                <button id="logout-button"
                    class="text-center w-full py-2 account-link hover:bg-red-500 hover:text-white">
                    Logout
                </button>
            </div>
        </div>

        @include('partials.profile-modal')
    </div>

</header>

<!-- Mobile Header -->
<header class="w-full bg-sidebar py-5 px-6 sm:hidden">
    <div class="flex items-center justify-between">
        <a href="/" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
        <button class="text-white text-3xl focus:outline-none" @click="isOpen = !isOpen">
            <i x-show="!isOpen" class="fas fa-bars"></i>
            <i x-show="isOpen" class="fas fa-times"></i>
        </button>

    </div>
    <nav :class="isOpen ? 'flex' : 'hidden'" class="flex flex-col pt-4">
        <a href="/dashboard" class="flex items-center active-nav-link text-white py-2 pl-4 nav-item">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
        </a>
        <a href="/table" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
            <i class="fas fa-table mr-3"></i>
            Tables
        </a>
        <a href="/form" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
            <i class="fas fa-align-left mr-3"></i>
            Forms
        </a>
        <a href="/tab" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
            <i class="fas fa-tablet-alt mr-3"></i>
            Tabbed Content
        </a>
        <button id="logout-button" class="text-center w-full py-2 account-link hover:bg-red-500 hover:text-white">
            Logout
        </button>
    </nav>
</header>

<script type="module">
    import {
        UserStore
    } from '/js/userStore.js';
    import {
        logout
    } from '/js/pages/logout.js';
    const logoutForms = document.getElementsByClassName('logout');

    document.addEventListener("DOMContentLoaded", async () => {
        console.log(UserStore)
        try {
            const user = await UserStore.load();

            document.getElementById("user-name").textContent = user.name || "User";
            const profilePath = user.profile ? `/storage/${user.profile}` : "/images/default-profile.png";
            document.getElementById("profile-image").src = profilePath;

        } catch (error) {
            console.error("Gagal mengambil data user:", error);
            document.getElementById("user-name").textContent = "Guest";
        }
    });

    document.getElementById("logout-button").addEventListener("click", async (e) => {
        e.preventDefault();
        await logout();
    });
</script>

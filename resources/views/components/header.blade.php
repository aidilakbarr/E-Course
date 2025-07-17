<!-- Desktop Header -->
<header class="w-full items-center bg-white py-2 px-6 hidden sm:flex">
    <div class="w-1/2"></div>
    <div x-data="{ isOpen: false, isProfileOpen: false }" class="relative w-1/2 flex justify-end">
        <div class="flex items-center h-12 font-bold px-4">
            {{ Auth::user()->name }}
        </div>
        <button @click="isOpen = !isOpen"
            class="realtive z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none">
            <img src="{{ Auth::user()->profile_url }}">
        </button>
        <div x-show="isOpen" class="absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-16">

            <button @click="isProfileOpen = !isProfileOpen" href="#"
                class="text-center w-full py-2 hover:text-white account-link">
                Profile
            </button>
            <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-center w-full py-2 account-link hover:text-white">Logout</button>
            </form>
        </div>
        @include('partials.profile-modal')
    </div>
</header>
<header class="w-full bg-sidebar py-5 px-6 sm:hidden">
    <div class="flex items-center justify-between">
        <a href="index.html" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
        <button class="text-white text-3xl focus:outline-none">
            <i x-show="!isOpen" class="fas fa-bars"></i>
            <i x-show="isOpen" class="fas fa-times"></i>
        </button>
    </div>

    <!-- Dropdown Nav -->
    <nav :class="isOpen ? 'flex' : 'hidden'" class="flex flex-col pt-4">
        <a href="/" class="flex items-center active-nav-link text-white py-2 pl-4 nav-item">
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
        <a href="tab" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
            <i class="fas fa-tablet-alt mr-3"></i>
            Tabbed Content
        </a>
        <form action="{{ route('auth.logout') }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                <i class="fas fa-sign-out-alt mr-3"></i>
                Logout
            </button>
        </form>
    </nav>
</header>

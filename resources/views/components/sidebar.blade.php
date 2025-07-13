<aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
    <div class="p-6">
        <a href="index.html" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>

    </div>
    <nav class="text-white text-base font-semibold pt-3">

        <x-nav-link href="/" icon="fa-tachometer-alt" :active="request()->routeIs('admin.dashboard.index')">
            Dashboard
        </x-nav-link>

        <x-nav-link href="/table" icon="fa-table" :active="request()->routeIs('table.index')">
            Users
        </x-nav-link>

        <x-nav-link href="/course" icon="fa-align-left" :active="request()->routeIs('course.index')">
            Courses
        </x-nav-link>

    </nav>

    <a href="#"
        class="absolute w-full upgrade-btn bottom-0 active-nav-link text-white flex items-center justify-center py-4">
        Dashboard V1.0.0
    </a>
</aside>

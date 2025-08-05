<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard')</title>
    @vite('resources/css/app.css')
    @vite(['resources/js/user.js'])

    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');

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
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
</head>

<body class="bg-gray-100 font-family-karla flex">
    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"
        integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    {{-- ChartJS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"
        integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
    @include('components.sidebar')
    <div class="w-full flex flex-col h-screen overflow-y-hidden">
        @include('components.header')
        <div class="w-full overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                @yield('content')
            </main>
        </div>
    </div>
    <!-- Modal Global -->
    <div x-data="{ open: false }" x-cloak x-show="open" x-transition id="modal-wrapper" @open-modal.window="open = true"
        @close-modal.window="open = false" class="fixed inset-0 z-50 bg-opacity-50 flex items-center justify-center">

        <div @click="open = false" class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>
        <div class="relative z-10 bg-white rounded-lg shadow-xl sm:max-w-lg w-full mx-4 sm:mx-0"
            @click.away="open = false" x-transition>
            <form method="POST" id="modal-form" class="bg-white p-6 rounded shadow w-full max-w-md">
                @csrf
                @method('DELETE')
                <h2 id="modal-title" class="text-xl font-semibold mb-4">Hapus Course</h2>
                <p id="modal-message" class="mb-6 text-gray-700">Apakah kamu yakin ingin menghapus course ini?</p>
                <div class="flex justify-end gap-3">
                    <button type="button"
                        class="px-4 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-100"
                        onclick="window.dispatchEvent(new Event('close-modal'))">
                        Batal
                    </button>
                    <button type="button" id="modal-button"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700" onclick="confirmDelete()">
                        Hapus
                    </button>

                </div>
            </form>
        </div>

    </div>


</body>

</html>

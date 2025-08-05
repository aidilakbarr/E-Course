@if (session('Success') || session('Error') || session('Warning'))
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2">

        {{-- Success --}}
        @if (session('Success'))
            <div class="toast bg-white dark:bg-gray-800 text-green-500 border-l-4 border-green-500">
                <x-toast-icon type="success" />
                <span class="toast-message">{{ session('Success') }}</span>
                <x-toast-close />
            </div>
        @endif

        {{-- Error --}}
        @if (session('Error'))
            <div class="toast bg-white dark:bg-gray-800 text-red-500 border-l-4 border-red-500">
                <x-toast-icon type="error" />
                <span class="toast-message">{{ session('Error') }}</span>
                <x-toast-close />
            </div>
        @endif

        {{-- Warning --}}
        @if (session('Warning'))
            <div class="toast bg-white dark:bg-gray-800 text-orange-500 border-l-4 border-orange-500">
                <x-toast-icon type="warning" />
                <span class="toast-message">{{ session('Warning') }}</span>
                <x-toast-close />
            </div>
        @endif

    </div>

    {{-- Auto Dismiss Script --}}
    <script>
        setTimeout(() => {
            document.querySelectorAll('.toast').forEach(toast => toast.remove());
        }, 5000);
    </script>
@endif

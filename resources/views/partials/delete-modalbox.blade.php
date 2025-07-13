{{-- resources/views/partials/delete-modal.blade.php --}}
<div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center" aria-labelledby="dialog-title"
    role="dialog" aria-modal="true">

    <!-- Overlay -->
    <div @click="open = false" class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

    <!-- Modal Box -->
    <div class="relative z-10 bg-white rounded-lg shadow-xl sm:max-w-lg w-full mx-4 sm:mx-0" @click.away="open = false"
        x-transition>
        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <div
                    class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                    <svg class="size-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 9v3.75M12 15.75h.008v.008H12v-.008ZM4.5 19.5h15L12 4.5 4.5 19.5z" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-base font-semibold text-gray-900" id="dialog-title">{{ $title ?? 'Delete Item' }}
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        {{ $message ?? 'Are you sure you want to delete this item?' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
            <form action="{{ $route ?? '#' }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-500 sm:ml-3 sm:w-auto cursor-pointer">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

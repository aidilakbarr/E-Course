import { usePage } from "@inertiajs/vue3";
import { watch } from "vue";

export function useFlash() {
    const page = usePage();

    watch(
        () => page.props.flash,
        (flash) => {
            if (flash?.success) {
                Swal.fire({
                    title: "Sukses!",
                    text: flash.success,
                    icon: "success",
                    timer: 2000,
                });
            }
            if (flash?.error) {
                Swal.fire({
                    title: "Error!",
                    text: flash.error,
                    icon: "error",
                    timer: 3000,
                });
            }
        },
        { deep: true, immediate: true }
    );
}

import { usePage } from "@inertiajs/vue3";

export function useActive() {
    const page = usePage();

    const isActive = (url) => {
        return page.url.startsWith(url);
    };

    return isActive;
}

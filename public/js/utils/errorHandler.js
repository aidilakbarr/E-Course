import { removeTokens } from "./tokenManager.js";
import { showAlert } from "./showAlert.js";

export function handleApiError(
    error,
    options = { redirectOnUnauthorized: true }
) {
    const message =
        error?.response?.data?.message || error.message || "Terjadi kesalahan";

    showAlert("Error", message);

    if (options.redirectOnUnauthorized) {
        removeTokens();
        setTimeout(() => {
            window.location.href = "/auth/login";
        }, 1500);
    }
}

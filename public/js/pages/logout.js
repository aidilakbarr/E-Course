import apiClient from "../utils/apiClient.js";
import { removeTokens } from "../utils/tokenManager.js";
import { UserStore } from "../userStore.js";

export async function logout() {
    try {
        await apiClient.delete("/auth/logout");
    } catch (err) {
        console.warn(
            "Logout failed on server:",
            err?.response?.data || err.message
        );
    }

    removeTokens();
    UserStore.clear();
    window.location.href = "/auth/login";
}

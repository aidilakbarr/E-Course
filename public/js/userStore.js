import apiClient from "./utils/apiClient.js";
import { handleApiError } from "./utils/errorhandler.js";

export const UserStore = {
    user: null,
    loading: false,

    async load() {
        if (this.user) return this.user;

        if (this.loading) {
            return new Promise((resolve) => {
                const interval = setInterval(() => {
                    if (this.user) {
                        clearInterval(interval);
                        resolve(this.user);
                    }
                }, 100);
            });
        }

        this.loading = true;

        try {
            const res = await apiClient.get("/auth/me");
            this.user = res.data.user;
            return this.user;
        } catch (e) {
            console.log("userstore");
            console.log("userstore", e);
            handleApiError(e, { redirectOnUnauthorized: true });
        } finally {
            this.loading = false;
        }
    },

    clear() {
        this.user = null;
    },
};

export const UserStore = {
    user: null,

    async load() {
        if (this.user) return this.user;

        const token = localStorage.getItem("access_token");
        if (!token) return null;

        try {
            const res = await axios.get("/auth/me");
            this.user = res.data;
            return this.user;
        } catch (err) {
            handleApiError(err, { redirectOnUnauthorized: false });
        }
    },

    clear() {
        this.user = null;
        localStorage.removeItem("access_token");
    },
};

window.UserStore = UserStore;

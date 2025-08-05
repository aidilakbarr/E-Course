console.log("Setting up interceptors");

axios.defaults.baseURL = "http://localhost:8000/api";
axios.defaults.withCredentials = true;

axios.interceptors.request.use(
    function (config) {
        const token = localStorage.getItem("access_token");
        if (token) {
            config.headers["Authorization"] = `Bearer ${token}`;
        }
        console.log("Request Intercepted", config.url);
        return config;
    },
    function (error) {
        return Promise.reject(error);
    }
);

axios.interceptors.response.use(
    function (response) {
        console.log("Response intercepted", response.config.url);
        return response;
    },
    async function (error) {
        const originalRequest = error.config;
        console.log("Error intercepted", originalRequest?.url);

        if (
            error.response &&
            error.response.status === 401 &&
            !originalRequest._retry
        ) {
            originalRequest._retry = true;
            try {
                const res = await axios.post("/auth/refresh");
                const newToken = res.data.data.token;
                localStorage.setItem("access_token", newToken);
                originalRequest.headers["Authorization"] = `Bearer ${newToken}`;
                console.log("Token refreshed, retrying", originalRequest.url);
                return axios(originalRequest);
            } catch (refreshError) {
                console.error("Refresh token gagal:", refreshError);
                localStorage.removeItem("access_token");
                window.location.href = "/auth/login";
            }
        }

        return Promise.reject(error);
    }
);

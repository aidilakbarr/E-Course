import {
    getAccessToken,
    getRefreshToken,
    setTokens,
    removeTokens,
    setAuthHeader,
} from "./tokenManager.js";

const API_URL = "http://localhost:8000/api";

const apiClient = axios.create({
    baseURL: API_URL,
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
    },
});

const initialAccessToken = getAccessToken() || "";
if (initialAccessToken) {
    setAuthHeader(apiClient, initialAccessToken);
}

apiClient.interceptors.request.use((config) => {
    console.log("Request ke:", config.url);
    console.log("Header:", config.headers);
    return config;
});

apiClient.interceptors.response.use(
    (response) => response,
    async (error) => {
        const originalRequest = error.config;

        if (
            error.response &&
            error.response.status === 401 &&
            error.response.data &&
            !originalRequest._retry &&
            !originalRequest.url.includes("/auth/login") &&
            !originalRequest.url.includes("/auth/register")
        ) {
            originalRequest._retry = true;

            const refreshToken = getRefreshToken();

            console.log({ refreshToken });

            if (!refreshToken || refreshToken == ("undefined" || null)) {
                removeTokens();
                throw new Error("Unauthorized: Token tidak tersedia.");
            }

            try {
                const refreshResponse = await axios.post(
                    `${API_URL}/auth/refresh`,
                    {
                        refresh_token: refreshToken,
                    }
                );

                if (refreshResponse.data.success) {
                    const newAccessToken = refreshResponse.data.access_token;
                    const newRefreshToken = refreshResponse.data.refresh_token;

                    setTokens(newAccessToken, newRefreshToken);
                    setAuthHeader(apiClient, newAccessToken);

                    originalRequest.headers[
                        "Authorization"
                    ] = `Bearer ${newAccessToken}`;
                    return apiClient(originalRequest);
                }

                throw new Error("Refresh token gagal");
            } catch (refreshError) {
                removeTokens();
                throw new Error(
                    refreshError.response?.data?.message ||
                        "Sesi Anda telah habis. Silakan login ulang."
                );
            }
        }

        throw error;
    }
);

export default apiClient;

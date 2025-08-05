export function setTokens(accessToken, refreshToken) {
    localStorage.setItem("access_token", accessToken);
    localStorage.setItem("refresh_token", refreshToken);
}

export function getAccessToken() {
    return localStorage.getItem("access_token");
}

export function getRefreshToken() {
    return localStorage.getItem("refresh_token");
}

export function removeTokens() {
    localStorage.removeItem("access_token");
}

export function setAuthHeader(axiosInstance, token) {
    if (token) {
        axiosInstance.defaults.headers.common[
            "Authorization"
        ] = `Bearer ${token}`;
    } else {
        delete axiosInstance.defaults.headers.common["Authorization"];
    }
}

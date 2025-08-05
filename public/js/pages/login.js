import apiClient from "../utils/apiClient.js";
import { setTokens, setAuthHeader } from "../utils/tokenManager.js";

document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById("loginForm");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const errorEmail = document.getElementById("error-email");
    const errorPassword = document.getElementById("error-password");
    const loginButton = loginForm.querySelector("button[type=submit]");
    const buttonIcon = loginButton.querySelector("svg");
    const buttonText = loginButton.querySelector("span");

    function clearErrors() {
        errorEmail.textContent = "";
        errorPassword.textContent = "";
    }

    if (loginForm) {
        loginForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            loginButton.disabled = true;
            loginButton.classList.add("opacity-60", "cursor-not-allowed");
            buttonIcon.style.display = "none";
            buttonText.textContent = "Loading...";

            clearErrors();

            const email = emailInput.value;
            const password = passwordInput.value;

            try {
                const response = await apiClient.post("/auth/login", {
                    email,
                    password,
                });

                if (response.data.success) {
                    setTokens(
                        response.data.access_token,
                        response.data.refresh_token
                    );
                    setAuthHeader(apiClient, response.data.access_token);

                    if (
                        response.data.user.role === "ADMIN" ||
                        response.data.user.role === "INSTRUCTOR"
                    ) {
                        await axios.post("/store-token", {
                            token: response.data.access_token,
                        });
                        window.location.href = "/dashboard";
                    } else {
                        await axios.post("/store-token", {
                            token: response.data.access_token,
                        });
                        window.location.href = "/dashboard";
                    }
                } else {
                    errorEmail.textContent = response.data.message;
                }
            } catch (error) {
                console.error(
                    "Login gagal:",
                    error.response ? error.response.data : error.message
                );

                if (
                    error.response &&
                    error.response.status === 422 &&
                    error.response.data.errors
                ) {
                    const errors = error.response.data.errors;
                    if (errors.email) {
                        errorEmail.textContent = errors.email[0];
                    }
                    if (errors.password) {
                        errorPassword.textContent = errors.password[0];
                    }
                } else {
                    const errorMessage =
                        error.response && error.response.data.message
                            ? error.response.data.message
                            : "Terjadi kesalahan tidak terduga saat login.";
                    errorEmail.textContent = errorMessage;
                }
            } finally {
                loginButton.disabled = false;
                loginButton.classList.remove(
                    "opacity-60",
                    "cursor-not-allowed"
                );
                buttonIcon.style.display = "inline";
                buttonText.textContent = "Login";
            }
        });
    }
});

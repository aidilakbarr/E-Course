<template>
    <AuthLayout>
        <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
            <div class="mt-12 flex flex-col items-center">
                <div class="w-full flex-1 mt-8">
                    <form @submit.prevent="submitLogin" class="mt-8">
                        <div class="mx-auto max-w-xs">
                            <input
                                v-model="email"
                                v-bind="emailAttrs"
                                name="email"
                                type="email"
                                class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white text-slate-600"
                                placeholder="Email"
                            />
                            <div class="text-red-500 text-sm">
                                {{ errors.email ?? "" }}
                            </div>
                            <span
                                v-if="page.props.errors.email"
                                class="text-red-500"
                            >
                                {{ page.props.errors.email }}
                            </span>

                            <input
                                v-model="password"
                                v-bind="passwordAttrs"
                                name="password"
                                type="password"
                                class="mt-5 w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white text-slate-600"
                                placeholder="Password"
                            />
                            <div class="text-red-500 text-sm">
                                {{ errors.password ?? "" }}
                            </div>

                            <span
                                v-if="page.props.errors.password"
                                class="text-red-500"
                            >
                                {{ page.props.errors.password }}
                            </span>

                            <span
                                v-if="page.props.errors.login"
                                class="text-red-500"
                            >
                                {{ page.props.errors.login }}
                            </span>

                            <button
                                type="submit"
                                class="mt-5 tracking-wide font-semibold bg-green-400 text-white w-full py-4 rounded-lg hover:bg-green-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none cursor-pointer"
                            >
                                <svg
                                    class="w-6 h-6 -ml-2"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path
                                        d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"
                                    />
                                    <circle cx="8.5" cy="7" r="4" />
                                    <path d="M20 8v6M23 11h-6" />
                                </svg>

                                <span class="ml-2" :disabled="isSubmitting">{{
                                    isSubmitting ? "Loading..." : "Login"
                                }}</span>
                            </button>

                            <div class="mt-5 text-center">
                                <Link
                                    href="/auth/register"
                                    class="text-sm text-blue-500 hover:text-blue-800"
                                >
                                    Not have an account? Register
                                </Link>
                            </div>

                            <p class="mt-6 text-xs text-gray-600 text-center">
                                I agree to abide by BelajarDulu
                                <a
                                    href="#"
                                    class="border-b border-gray-500 border-dotted"
                                    >Terms of Service</a
                                >
                                and its
                                <a
                                    href="#"
                                    class="border-b border-gray-500 border-dotted"
                                    >Privacy Policy</a
                                >
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="flex-1 bg-green-100 text-center hidden lg:flex">
            <div
                class="m-12 xl:m-16 w-full bg-contain bg-center bg-no-repeat"
                :style="{ backgroundImage: `url(${loginImage})` }"
            ></div>
        </div>
    </AuthLayout>
</template>

<script setup>
import { Link, router, usePage } from "@inertiajs/vue3";
import AuthLayout from "../../Layouts/AuthLayout.vue";
import loginImage from "@/assets/images/login.png";
import { useForm } from "vee-validate";
import * as yup from "yup";
const page = usePage();

const { values, errors, defineField, handleSubmit, isSubmitting } = useForm({
    validationSchema: yup.object({
        email: yup.string().email().required(),
        password: yup.string().required(),
    }),
});

const [email, emailAttrs] = defineField("email", {
    validateOnModelUpdate: false,
});

const [password, passwordAttrs] = defineField("password", {
    validateOnModelUpdate: false,
});

const submitLogin = handleSubmit((values) => {
    isSubmitting.value = true;
    router.post("/auth/login", values, {
        onFinish: () => {
            isSubmitting.value = false;
        },
    });
});
</script>

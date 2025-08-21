<template>
    <AuthLayout>
        <div class="flex-1 bg-green-100 text-center hidden lg:flex">
            <div
                class="m-12 xl:m-16 w-full bg-contain bg-center bg-no-repeat"
                :style="{ backgroundImage: `url(${loginImage})` }"
            ></div>
        </div>
        <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
            <div class="mt-12 flex flex-col items-center">
                <div class="w-full flex-1 mt-8">
                    <div class="flex flex-col items-center">
                        <button
                            class="hidden w-full max-w-xs font-bold shadow-sm rounded-lg py-3 bg-green-100 text-gray-800 flex items-center justify-center transition-all duration-300 ease-in-out focus:outline-none hover:shadow focus:shadow-sm focus:shadow-outline cursor-pointer"
                        >
                            <div class="bg-white p-2 rounded-full">
                                <svg class="w-4" viewBox="0 0 533.5 544.3">
                                    <path
                                        d="M533.5 278.4c0-18.5-1.5-37.1-4.7-55.3H272.1v104.8h147c-6.1 33.8-25.7 63.7-54.4 82.7v68h87.7c51.5-47.4 81.1-117.4 81.1-200.2z"
                                        fill="#4285f4"
                                    />
                                    <path
                                        d="M272.1 544.3c73.4 0 135.3-24.1 180.4-65.7l-87.7-68c-24.4 16.6-55.9 26-92.6 26-71 0-131.2-47.9-152.8-112.3H28.9v70.1c46.2 91.9 140.3 149.9 243.2 149.9z"
                                        fill="#34a853"
                                    />
                                    <path
                                        d="M119.3 324.3c-11.4-33.8-11.4-70.4 0-104.2V150H28.9c-38.6 76.9-38.6 167.5 0 244.4l90.4-70.1z"
                                        fill="#fbbc04"
                                    />
                                    <path
                                        d="M272.1 107.7c38.8-.6 76.3 14 104.4 40.8l77.7-77.7C405 24.6 339.7-.8 272.1 0 169.2 0 75.1 58 28.9 150l90.4 70.1c21.5-64.5 81.8-112.4 152.8-112.4z"
                                        fill="#ea4335"
                                    />
                                </svg>
                            </div>
                            <span class="ml-4">register with Google</span>
                        </button>
                    </div>

                    <form @submit.prevent="submitRegister" class="mt-8">
                        <div class="mx-auto max-w-xs">
                            <input
                                v-model="name"
                                v-bind="nameAttrs"
                                class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white text-slate-600"
                                type="text"
                                placeholder="Name"
                            />
                            <div class="text-red-500 text-sm">
                                {{ errors.name ?? "" }}
                            </div>

                            <input
                                v-model="email"
                                v-bind="emailAttrs"
                                class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white text-slate-600 mt-5"
                                type="email"
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
                                class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white text-slate-600 mt-5"
                                type="password"
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

                            <input
                                v-model="password_confirmation"
                                v-bind="password_confirmationAttrs"
                                class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white text-slate-600 mt-5"
                                type="password"
                                placeholder="Confirm Password"
                            />
                            <div class="text-red-500 text-sm">
                                {{ errors.password_confirmation ?? "" }}
                            </div>

                            <button
                                type="submit"
                                :disabled="isSubmitting"
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
                                <span class="ml-2">{{
                                    isSubmitting ? "Loading..." : "Register"
                                }}</span>
                            </button>

                            <div class="mt-5 text-center">
                                <Link
                                    class="inline-block text-sm text-blue-500 hover:text-blue-800"
                                    href="/auth/login"
                                >
                                    have an account? Login
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
    </AuthLayout>
</template>

<script setup lang="ts">
import loginImage from "@/assets/images/login.png";
import AuthLayout from "../../Layouts/AuthLayout.vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import { useForm } from "vee-validate";
import * as yup from "yup";

const page = usePage();
const { values, errors, defineField, handleSubmit, isSubmitting } = useForm({
    validationSchema: yup.object({
        name: yup.string().required().min(6),
        email: yup.string().email().required(),
        password: yup.string().required().min(6),
        password_confirmation: yup.string().required().min(6),
    }),
});

const [name, nameAttrs] = defineField("name", {
    validateOnModelUpdate: false,
});
const [email, emailAttrs] = defineField("email", {
    validateOnModelUpdate: false,
});
const [password, passwordAttrs] = defineField("password", {
    validateOnModelUpdate: false,
});
const [password_confirmation, password_confirmationAttrs] = defineField(
    "password_confirmation",
    {
        validateOnModelUpdate: false,
    }
);

const submitRegister = handleSubmit((values) => {
    isSubmitting.value = true;
    router.post("/auth/register", values, {
        onFinish: () => {
            isSubmitting.value = false;
        },
    });
});
</script>

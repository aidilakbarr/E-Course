<div x-show="isProfileOpen" x-transition x-cloak class="fixed inset-0 z-50 flex items-center justify-center"
    aria-labelledby="dialog-title" role="dialog" aria-modal="true">

    <!-- Overlay -->
    <div @click="isProfileOpen = false" class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

    <section class="py-10 z-10 my-auto dark:bg-gray-900">
        <div class="lg:w-[36rem] md:w-[90%] w-[96%] mx-auto flex gap-4">
            <div
                class="lg:w-[88%] sm:w-[88%] w-full mx-auto shadow-2xl p-4 rounded-xl h-fit self-center dark:bg-gray-800/40 bg-white">
                <div>
                    <h1 class="lg:text-3xl md:text-2xl text-xl font-serif font-extrabold mb-2 dark:text-white">Profile
                    </h1>

                    <form method="POST" enctype="multipart/form-data" id="profile-form">
                        @csrf
                        @method('PUT')

                        <div x-data="{ preview: '' }" id="profile-modal-image" class="text-center">
                            <input type="file" id="upload_profile" name="profile" class="hidden"
                                @change="if($event.target.files[0]) { 
                                    const reader = new FileReader(); 
                                    reader.onload = (e) => preview = e.target.result; 
                                    reader.readAsDataURL($event.target.files[0]); 
                                }" />

                            <div class="mx-auto flex justify-center w-[141px] h-[141px] bg-blue-300/20 rounded-full bg-cover bg-center bg-no-repeat"
                                :style="`background-image: url('${preview || '/images/default-profile.png'}')`">

                                <div class="bg-white/90 rounded-full w-6 h-6 text-center ml-28 mt-4 cursor-pointer">
                                    <label for="upload_profile" class="cursor-pointer">
                                        <svg class="w-4 h-4 mt-[5px] mx-auto" fill="none" stroke="currentColor"
                                            stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 10.5L19.5 6.75M15.75 6.75L19.5 10.5M3 3h7.5l2 2H21v12.75a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 17.25V3z">
                                            </path>
                                        </svg>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <h2 class="text-center mt-1 font-semibold dark:text-gray-300">Upload Profile</h2>

                        <div class="flex flex-col lg:flex-row gap-2 justify-center w-full mt-4">
                            <div class="w-full">
                                <label class="dark:text-gray-300">Name</label>
                                <input type="text" id="name" name="name"
                                    class="mt-2 p-4 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                    placeholder="Name">
                            </div>
                        </div>

                        <div class="flex flex-col lg:flex-row gap-2 justify-center w-full">
                            <div class="w-full">
                                <label class="dark:text-gray-300">Email</label>
                                <input type="email" id="email" name="email"
                                    class="mt-2 p-4 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                    placeholder="Email">
                            </div>
                        </div>

                        <div class="flex flex-col lg:flex-row gap-2 justify-center w-full">
                            <div class="w-full">
                                <label class="dark:text-gray-300">Password</label>
                                <input type="password" id="password" name="password"
                                    class="mt-2 p-4 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                    placeholder="Leave blank if unchanged">
                            </div>
                        </div>

                        <div class="w-full rounded-lg bg-blue-500 mt-4 text-white text-lg font-semibold">
                            <button type="submit" class="w-full p-4">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</div>
<script type="module">
    import {
        UserStore
    } from '/js/userStore.js';
    import apiClient from '/js/utils/apiClient.js';


    document.addEventListener("DOMContentLoaded", async () => {
        try {
            const user = await UserStore.load();

            document.getElementById("name").value = user.name ?? "";
            document.getElementById("email").value = user.email ?? "";
            const bgDiv = document.querySelector('#profile-modal-image > div');
            if (user.profile && bgDiv) {
                const fullUrl = `/storage/${user.profile}`;
                bgDiv.style.backgroundImage = `url('${fullUrl}')`;
            }



            const form = document.getElementById("profile-form");
            form.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(form);
                try {
                    const updateRes = await apiClient.post("/profile/update", formData, {
                        headers: {
                            "Content-Type": "multipart/form-data"
                        }
                    });

                    alert("Profile updated successfully.");
                    window.location.reload();
                } catch (err) {
                    console.error("Update error:", err);
                    alert("Update failed.");
                }
            });

        } catch (error) {
            console.error("Failed loading user data:", error);
        }
    });
</script>

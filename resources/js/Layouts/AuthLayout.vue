<template>
    <div
        class="min-h-screen bg-gray-100 text-gray-100 flex justify-center font-family-karla"
    >
        <div
            class="max-w-screen-xl m-0 sm:m-10 bg-white shadow sm:rounded-lg flex justify-center flex-1"
        >
            <slot />
        </div>
    </div>
</template>

<script>
export default {
    name: "AuthLayout",
};
</script>

<style>
.font-family-karla {
    font-family: karla;
}

.bg-sidebar {
    background: #3d68ff;
}

.cta-btn {
    color: #3d68ff;
}

.upgrade-btn {
    background: #1947ee;
}

.upgrade-btn:hover {
    background: #0038fd;
}

.active-nav-link {
    background: #1947ee;
}

.nav-item:hover {
    background: #1947ee;
}

.account-link:hover {
    background: #3d68ff;
}

[x-cloak] {
    display: none !important;
}
</style>

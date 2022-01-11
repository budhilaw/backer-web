<template>
    <header class="flex items-center">
        <div style="height: 54px" class="pr-5">
            <img src="/images/logo.svg" alt="logo" class="h-full" />
        </div>
        <ul class="flex items-center">
            <li>
                <router-link class="text-white hover:text-green-500 text-lg px-4 py-3"
                             to="/"
                >Home</router-link>
            </li>
            <li>
                <router-link class="text-white hover:text-green-500 text-lg px-4 py-3"
                             to="/"
                >Project</router-link>
            </li>
            <li>
                <router-link class="text-white hover:text-green-500 text-lg px-4 py-3"
                             to="/"
                >Features</router-link>
            </li>
            <li>
                <router-link class="text-white hover:text-green-500 text-lg px-4 py-3"
                             to="/"
                >Success Stories</router-link>
            </li>
        </ul>
        <ul class="flex ml-auto items-center mt-2">
            <li v-if="!access_token">
                <router-link class="inline-block bg-transparent border-white border hover:bg-white hover:bg-opacity-25 text-white font-light w-40 text-center px-6 py-1 text-lg rounded-full mr-4"
                             to="/register"
                >Sign Up</router-link>
            </li>
            <li v-if="!access_token">
                <router-link class="inline-block bg-transparent border-white border hover:bg-white hover:bg-opacity-25 text-white font-light w-40 text-center px-6 py-1 text-lg rounded-full"
                             to="/login"
                >Login</router-link>
            </li>
            <li v-if="access_token">
                <router-link class="inline-block bg-transparent border-white border hover:bg-white hover:bg-opacity-25 text-white font-light w-40 text-center px-6 py-1 text-lg rounded-full mr-4"
                             to="/dashboard"
                >Dashboard</router-link>
            </li>
            <li v-if="access_token">
                <router-link class="inline-block bg-transparent border-white border hover:bg-white hover:bg-opacity-25 text-white font-light w-40 text-center px-6 py-1 text-lg rounded-full"
                             to="/logout"
                >Logout</router-link>
            </li>
        </ul>
    </header>
</template>

<script>
export default {
    name: "NavLinks",
    data() {
        return {
            access_token: localStorage.access_token
        }
    }
}
</script>

<style scoped>

</style>

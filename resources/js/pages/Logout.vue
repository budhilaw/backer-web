<template>
    <h3 class="mx-4 my-8">You will be redirected</h3>
</template>

<script>
import { useRouter } from "vue-router";

export default {
    name: "Logout",
    mounted() {
        const router = useRouter()
        localStorage.clear()
        router.push({name: 'Home'})
    }
}
</script>

<style scoped>

</style>

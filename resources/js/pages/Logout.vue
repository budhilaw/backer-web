<template>
    <h3 class="mx-4 my-8">You will be redirected</h3>
</template>

<script>
import { useRouter } from "vue-router";
import { inject } from "vue";

export default {
    name: "Logout",
    mounted() {
        const userStore = inject('userStore')
        const campaignStore = inject('campaignStore')
        const router = useRouter()

        localStorage.clear()
        userStore.methods.resetAll()
        campaignStore.methods.resetAll()

        router.push({ name: 'Home' })
    }
}
</script>

<style scoped>

</style>

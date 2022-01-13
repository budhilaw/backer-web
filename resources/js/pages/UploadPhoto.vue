<template>
    <div class="auth-page">
        <div class="container mx-auto h-screen flex justify-center items-center">
        <div class="w-full lg:w-1/3 px-10 lg:px-0">
            <div class="flex justify-center items-center mx-auto mb-4 w-40">
                <div class="relative">
                    <input @change="userStore.methods.uploadAvatar($event, id)" id="photo-upload" type="file" accept="image/" hidden>
                    <button @click="chooseFile">
                        <div v-if="userStore.state.userProfile?.avatar">
                            <img
                                :src="baseURL + userStore.state.userProfile.avatar"
                                alt=""
                                class="rounded-full border-white border-4"
                            />
                        </div>
                        <div v-else>
                            <img
                                :src="baseURL + '/avatar/avatar.jpg'"
                                alt=""
                                class="rounded-full border-white border-4"
                            />
                        </div>
                        <img
                            :src="baseURL + '/avatar/icon-avatar-add.svg'"
                            alt=""
                            class="absolute right-0 bottom-0 pb-2"
                        />
                    </button>
                </div>
            </div>
            <h2 class="font-normal mb-3 text-3xl text-white text-center">
                Hi, {{ userStore.state.userProfile?.name?.split(" ")[0] }}
            </h2>
            <p class="text-white text-center font-light">
                You can change your avatar here
            </p>
            <div class="mb-4 mt-6">
                <div class="mb-3">
                    <router-link
                        :to="{ name: 'Dashboard' }"
                        class="block w-full bg-orange-button hover:bg-green-button text-white font-semibold px-6 py-4 text-lg rounded-full"
                    >
                        Go to Dashboard
                    </router-link>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
import {computed, onMounted, inject, reactive} from "vue";

export default {
    name: "UploadPhoto",
    props: {
        id: {
            required: true,
            type: String
        }
    },
    setup() {
        const userStore = inject('userStore')

        let uploadForm = reactive({
            image: ''
        })

        const baseURL = computed(() => {
            return `${process.env.APP_URL}/storage/`
        })

        onMounted(() => {
            userStore.methods.getMyProfile()
        })

        const chooseFile = () => {
            document.getElementById("photo-upload").click()
        }

        const doUpload = (id) => {
            userStore.methods.uploadAvatar(uploadForm, id)
        }

        return {
            userStore,
            baseURL,
            chooseFile,
            doUpload
        }
    }
}
</script>

<style scoped>

</style>

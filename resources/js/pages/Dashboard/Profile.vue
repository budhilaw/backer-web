<template>
    <div class="project-page bg-purple-progress">
        <Navbar />
        <section class="container mx-auto pt-8 relative">
            <div class="flex justify-between items-center">
                <div class="w-full mr-6">
                    <h2 class="text-4xl text-white mb-2 font-medium">My Profile</h2>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div class="w-3/4 mr-6">
                    <h3 class="text-2xl text-white mb-4">Edit My Profile</h3>
                </div>
            </div>

            <div class="block mb-2">
                <div class="w-full lg:max-w-full lg:flex mb-4">
                    <div class="w-full border border-gray-400 bg-white rounded p-8 flex flex-col justify-between leading-normal">
                        <div class="w-full">
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                        Personal Name
                                    </label>
                                    <input
                                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        type="text"
                                        v-model="userStore.formState.user.name"
                                        placeholder="Your Name"
                                    />
                                    <div v-if="userStore.state.error[0]?.name?.[0]" class="bg-gray-100 p-2 my-4 text-sm text-red-600">
                                        {{ userStore.state.error[0].name[0] }}
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                        Occupation
                                    </label>
                                    <input
                                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        type="text"
                                        v-model="userStore.formState.user.occupation"
                                        placeholder="Your occupation"
                                    />
                                    <div v-if="userStore.state.error[0]?.occupation?.[0]" class="bg-gray-100 p-2 my-4 text-sm text-red-600">
                                        {{ userStore.state.error[0].occupation[0] }}
                                    </div>
                                </div>
                                <div class="w-full px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-3">
                                        E-mail
                                    </label>
                                    <input
                                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        type="text"
                                        v-model="userStore.formState.user.email"
                                        placeholder="Your E-mail"
                                    />
                                    <div v-if="userStore.state.error[0]?.email?.[0]" class="bg-gray-100 p-2 my-4 text-sm text-red-600">
                                        {{ userStore.state.error[0].email[0] }}
                                    </div>
                                </div>
                                <div class="w-full px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                        New Password
                                    </label>
                                    <input
                                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        type="password"
                                        v-model="changePass.password"
                                        placeholder="Leave empty if you not change your password"
                                    />
                                    <div v-if="userStore.state.error[0]?.password?.[0]" class="bg-gray-100 p-2 my-4 text-sm text-red-600">
                                        {{ userStore.state.error[0].password[0] }}
                                    </div>
                                </div>
                                <div class="w-full px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                        New Password Confirmation
                                    </label>
                                    <input
                                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        type="password"
                                        v-model="changePass.password_confirmation"
                                        placeholder="Leave empty if you not change your password"
                                    />
                                </div>
                                <div class="w-full px-3">
                                    <button @click="doUpdate"
                                       class="bg-green-button hover:bg-green-button text-white font-bold px-4 py-1 rounded inline-flex items-center">
                                        Change
                                    </button>

                                    <router-link :to="{ name: 'UploadPhoto', params: { id: userStore.state.error[0].id } }"
                                            class="bg-green-button hover:bg-green-button text-white font-bold px-4 py-1 rounded inline-flex items-center">
                                        Change
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <Footer />
    </div>
</template>

<script>
import Navbar from "../../components/Navbar";
import Footer from "../../components/Footer";
import { UploadMedia } from "@s1modev/media-upload";
import { onMounted, reactive, inject } from "vue";

export default {
    name: "UpdateCampaign",
    components: { Navbar, Footer, UploadMedia },
    setup() {
        const campaignStore = inject('campaignStore')
        const userStore = inject('userStore')
        const changePass = reactive({
            password: '',
            password_confirmation: ''
        })

        onMounted(() => {
            userStore.methods.getMyProfile()
        })

        const doUpdate = () => {
            let id = userStore.formState.user.id
            let data = userStore.formState.user
            data.password = changePass.password
            data.password_confirmation = changePass.password_confirmation
            userStore.methods.updateProfile(id, data)
        }

        return {
            changePass,
            userStore,
            doUpdate
        }
    },
}
</script>

<style scoped>

</style>

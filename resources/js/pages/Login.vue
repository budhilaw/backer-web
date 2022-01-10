<template>
    <div class="auth-page">
        <div class="h-screen flex justify-center items-center">
            <div class="hidden md:block lg:w-1/3 bg-white h-full auth-background rounded-tr-lg rounded-br-lg" />
            <div class="w-auto md:w-2/4 lg:w-2/3 flex justify-center items-center">
                <div class="w-full lg:w-1/2 px-10 lg:px-0">
                    <h2 class="font-normal mb-6 text-3xl text-white">
                        Sign In to Your Account
                    </h2>

                    <div v-if="userStore.state.error" class="bg-gray-100 p-2 my-4 text-sm text-red-600">
                        {{ userStore.state.error }}
                    </div>

                    <div class="mb-6">
                        <div class="mb-4">
                            <label class="font-normal text-lg text-white block mb-3">
                                Email Address
                            </label>
                            <input
                                type="email"
                                class="auth-form focus:outline-none focus:bg-purple-hover focus:shadow-outline focus:border-purple-hover-stroke focus:text-gray-100"
                                placeholder="Write your email address here"
                                v-model="form.email"
                            />
<!--                            <div v-if="errors.email" class="bg-gray-100 p-2 my-4 text-sm text-red-600">-->
<!--                                {{ errors.email }}-->
<!--                            </div>-->
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="mb-4">
                            <label class="font-normal text-lg text-white block mb-3">
                                Password
                            </label>
                            <input
                                type="password"
                                class="auth-form focus:outline-none focus:bg-purple-hover focus:shadow-outline focus:border-purple-hover-stroke focus:text-gray-100"
                                placeholder="Write your password here"
                                v-model="form.password"
                            />
<!--                            <div v-if="errors.password" class="bg-gray-100 p-2 my-4 text-sm text-red-600">-->
<!--                                {{ errors.password }}-->
<!--                            </div>-->
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="mb-4">
                            <button
                                @click="doLogin"
                                class="block w-full bg-orange-button hover:bg-green-button text-white font-semibold px-6 py-4 text-lg rounded-full"
                            >
                                Sign In
                            </button>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-white text-md">
                            Don't have account?
                            <a href="/register" class="no-underline text-orange-button"
                            >Sign Up</a
                            >.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { inject, reactive } from "vue";

export default {
    name: "Login",
    setup() {
        const userStore = inject('userStore')

        let form = reactive({
            'email': '',
            'password': '',
        })

        const doLogin = () => {
            userStore.methods.login(form)
        }

        return {
            userStore,
            form,
            doLogin
        }
    }
}
</script>

<style scoped>

</style>

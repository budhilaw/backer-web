<template>
    <div class="auth-page">
        <div class="h-screen flex justify-center items-center">
            <div
                class="hidden md:block lg:w-1/3 bg-white h-full auth-background rounded-tr-lg rounded-br-lg"
            ></div>
            <div class="w-auto md:w-2/4 lg:w-2/3 flex justify-center items-center">
                <div class="w-full lg:w-1/2 px-10 lg:px-0">
                    <h2 class="font-normal mb-6 text-3xl text-white">
                        Sign Up Account
                    </h2>
                    <div class="mb-6">
                        <div class="mb-4">
                            <label class="font-normal text-lg text-white block mb-3">
                                Full Name
                            </label>
                            <input
                                v-model="form.name"
                                type="text"
                                class="auth-form focus:outline-none focus:bg-purple-hover focus:shadow-outline focus:border-purple-hover-stroke focus:text-gray-100"
                                placeholder="Write Your Name Here"
                            />
                            <div v-if="errors.name" class="bg-gray-100 p-2 my-4 text-sm text-red-600">
                                {{ errors.name }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="mb-4">
                            <label class="font-normal text-lg text-white block mb-3">
                                Occupation
                            </label>
                            <input
                                v-model="form.occupation"
                                type="text"
                                class="auth-form focus:outline-none focus:bg-purple-hover focus:shadow-outline focus:border-purple-hover-stroke focus:text-gray-100"
                                placeholder="Write your occupation here"
                            />
                            <div v-if="errors.occupation" class="bg-gray-100 p-2 my-4 text-sm text-red-600">
                                {{ errors.occupation }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="mb-4">
                            <label class="font-normal text-lg text-white block mb-3">
                                Email Address
                            </label>
                            <input
                                v-model="form.email"
                                type="email"
                                class="auth-form focus:outline-none focus:bg-purple-hover focus:shadow-outline focus:border-purple-hover-stroke focus:text-gray-100"
                                placeholder="Write your email address here"
                            />
                            <div v-if="errors.email" class="bg-gray-100 p-2 my-4 text-sm text-red-600">
                                {{ errors.email }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="mb-4">
                            <label class="font-normal text-lg text-white block mb-3">
                                Password
                            </label>
                            <input
                                v-model="form.password"
                                type="password"
                                class="auth-form focus:outline-none focus:bg-purple-hover focus:shadow-outline focus:border-purple-hover-stroke focus:text-gray-100"
                                placeholder="Type your password here"
                            />
                            <div v-if="errors.password" class="bg-gray-100 p-2 my-4 text-sm text-red-600">
                                {{ errors.password }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="mb-4">
                            <label class="font-normal text-lg text-white block mb-3">
                                Password Confirmation
                            </label>
                            <input
                                v-model="form.password_confirmation"
                                type="password"
                                class="auth-form focus:outline-none focus:bg-purple-hover focus:shadow-outline focus:border-purple-hover-stroke focus:text-gray-100"
                                placeholder="Type the password confirmation here"
                            />
                            <div v-if="errors.password_confirmation" class="bg-gray-100 p-2 my-4 text-sm text-red-600">
                                {{ errors.password_confirmation }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="mb-4">
                            <button
                                @click="saveUser"
                                class="block w-full bg-orange-button hover:bg-green-button text-white font-semibold px-6 py-4 text-lg rounded-full"
                            >
                                Continue Sign Up
                            </button>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-white text-md">
                            Already have account?
                            <a href="/login" class="no-underline text-orange-button"
                            >Sign In</a
                            >.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive } from "vue";
import useUser from "../composables/user";

export default {
    name: "Register",
    setup() {
        let form = reactive({
            'avatar': 'default',
            'name': '',
            'occupation': '',
            'email': '',
            'password': '',
            'password_confirmation': '',
        })

        const { errors, register } = useUser()

        const saveUser = async () =>  {
            await register({...form});
        }

        return {
            form,
            errors,
            saveUser,
        }
    }
}
</script>

<style scoped>

</style>

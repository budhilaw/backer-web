<template>
    <div class="project-page bg-purple-progress">
        <Navbar />
        <section class="container mx-auto pt-8 relative h-screen">
            <div class="flex justify-between items-center mb-6">
                <div class="w-3/4 mr-6">
                    <h2 class="text-4xl text-white mb-2 font-medium">Dashboard</h2>
                    <ul class="flex mt-2">
                        <li class="mr-6">
                            <router-link
                                class="text-gray-300 hover:text-gray-100"
                                to="/dashboard">
                                Your Projects
                            </router-link>
                        </li>
                        <li class="mr-6">
                            <router-link
                                class="text-gray-100 font-bold"
                                to="/dashboard/transactions">
                                Your Transactions
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
            <hr />
            <div class="block mb-2">
                <div v-if="userStore.state.transactions" class="w-full lg:max-w-full lg:flex flex-col justify-between mb-4">
                    <div v-for="trans in userStore.state.transactions"
                         class="w-full border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-8 mb-4 leading-normal">
                        <div>
                            <router-link
                                :to="{ name: 'SingleCampaign', params: { slug: trans.campaign.slug } }"
                                class="text-gray-900 font-bold text-xl mb-1">
                                {{ trans.campaign.name }}
                            </router-link>
                            <p class="text-sm text-gray-600 flex items-center mb-2">
                                {{ trans.rupiah_amount }} &middot; {{ trans.date_transaction }}
                            </p>
                            <div v-if="trans.status == 1">
                                <span class="text-xl font-bold text-green-600 flex items-center">
                                    Paid
                                </span>
                            </div>
                            <div v-else>
                                <router-link
                                    :to="{ name: 'Dashboard' }"
                                    v-if="userStore.state.userProfile.role === 0"
                                    class="bg-green-button text-white py-2 px-4 mt-8 rounded">
                                    Pay Now
                                </router-link>

                                <div v-if="userStore.state.userProfile.role === 1">
                                    <span class="text-xl font-bold text-red-600 flex items-center my-4">
                                        Unpaid
                                    </span>

                                    <button
                                        @click="doVerify(trans.id)"
                                        class="bg-green-600 text-white py-2 px-4 rounded">
                                        Verify
                                    </button>
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
import {inject, onMounted} from "vue";

export default {
    name: "Transactions",
    components: { Navbar, Footer },
    setup() {
        const userStore = inject('userStore')

        onMounted(() => {
            userStore.methods.getTransactions()
            userStore.methods.getMyProfile()
        })

        const doVerify = (id) => {
            userStore.methods.verifyTransactions(id)
        }

        return {
            userStore,
            doVerify
        }
    }
}
</script>

<style scoped>

</style>

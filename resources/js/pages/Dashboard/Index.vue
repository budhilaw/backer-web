<template>
    <div class="project-page bg-purple-progress">
        <Navbar />
        <section class="container mx-auto pt-8 relative">
            <div class="flex justify-between items-center mb-6">
                <div class="w-3/4 mr-6">
                    <h2 class="text-4xl text-white mb-2 font-medium">Dashboard</h2>
                    <ul class="flex mt-2">
                        <li class="mr-6">
                            <router-link class="text-white font-bold" to="/dashboard"> Your Projects </router-link>
                        </li>
                        <li class="mr-6">
                            <router-link
                                class="text-gray-300 hover:text-gray-100"
                                to="/dashboard/transactions">
                                Your Transactions
                            </router-link>
                        </li>
                    </ul>
                </div>
                <div class="w-1/4 text-right">
                    <router-link
                        to="/dashboard/campaign/create"
                        class="bg-orange-button hover:bg-green-button text-white font-bold py-4 px-4 rounded inline-flex items-center">
                        + Create Campaign
                    </router-link>
                </div>
            </div>
            <hr />
            <div v-if="campaignStore.state.campaigns.length">
                <div v-for="(item, index) in campaignStore.state.campaigns" :key="item.id">
                    <div class="block mb-4">
                        <div class="w-full lg:max-w-full lg:flex mb-4">
                            <div v-if="item.image"
                                 class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
                                 v-bind:style="{ 'background-image': 'url(' + baseURL + item.image.file_name + ')' }">
                            </div>
                            <div class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-8 flex flex-col justify-between leading-normal">
                                <div class="mb-8">
                                    <div class="text-gray-900 font-bold text-xl mb-1">
                                        {{ item.name }}
                                    </div>
                                    <p class="text-sm text-gray-600 flex items-center mb-2">
                                        Rp. {{ item.goal_amount }} &middot;
                                        {{ (item.current_amount / item.goal_amount)*100 }}%
                                    </p>
                                    <p class="text-gray-700 text-base overflow-ellipsis overflow-hidden">
                                        {{ item.description }}
                                    </p>
                                </div>
                                <div class="flex items-center">
                                    <router-link
                                        :to="{ name: 'SingleCampaign', params: { slug: item.slug } }"
                                        class="bg-green-button text-white py-2 px-4 rounded"
                                    >
                                        Detail
                                    </router-link>

                                    <router-link
                                        :to="{ name: 'UploadImage', params: { id: item.id } }"
                                        class="bg-blue-600 text-white py-2 px-4 ml-4 rounded"
                                    >
                                        Upload Image
                                    </router-link>

                                    <button class="bg-red-500 text-white py-2 px-4 ml-4 rounded"
                                            @click="campaignStore.methods.removeCampaign(item.id, index)">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <div class="h-screen mt-8">
                    <h4 class="text-2xl text-white">
                        You don't have any projects. <br />
                        Let's create one!
                    </h4>
                </div>
            </div>
        </section>
        <Footer />
    </div>
</template>

<script>
import Navbar from "../../components/Navbar";
import { onMounted, computed, inject } from "vue";
import Footer from "../../components/Footer";
import Pagination from "../../components/Pagination";

export default {
    name: "Index",
    components: { Navbar, Footer, Pagination },
    setup() {
        const campaignStore = inject('campaignStore')

        onMounted(() => {
            campaignStore.methods.getCampaigns()
        })

        const baseURL = computed(() => {
            return `${process.env.APP_URL}/storage/`
        })

        return {
            campaignStore,
            baseURL
        }
    },
}
</script>

<style scoped>

</style>

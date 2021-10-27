<template>
    <div class="project-page">
        <Navbar />
        <section class="container mx-auto pt-8 relative">
            <div class="flex justify-between items-center mb-6">
                <div class="w-3/4 mr-6">
                    <h2 class="text-4xl text-white mb-2 font-medium">Dashboard</h2>
                    <ul class="flex mt-2">
                        <li class="mr-6">
                            <a class="text-white font-bold" href="#"> Your Projects </a>
                        </li>
                        <li class="mr-6">
                            <a class="text-gray-300 hover:text-gray-100"
                               href="/dashboard/transactions.html">
                                Your Transactions
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="w-1/4 text-right">
                    <a href="/dashboard/create.html"
                       class="bg-orange-button hover:bg-green-button text-white font-bold py-4 px-4 rounded inline-flex items-center"
                    >
                        + Create Campaign
                    </a>
                </div>
            </div>
            <hr />
            <div v-for="item in campaigns" :key="item.id">
                <div class="block mb-4">
                <div class="w-full lg:max-w-full lg:flex mb-4">
                    <div
                        class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
                        style="
                background-image: url('https://tailwindcss.com/img/card-left.jpg');
              "
                    ></div>
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
                            <a
                                href="/dashboard/detail.html"
                                class="bg-green-button text-white py-2 px-4 rounded"
                            >
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
        <footer class="bg-purple-progress py-20 text-white text-lg">
            <div class="container mx-auto">
                <div class="sm:flex mb-4">
                    <div class="sm:w-1/2 sm:mt-0 mt-8 h-auto">
                        <img src="/images/logo-footer.svg" alt="" class="mb-3" />
                        <p class="font-light">
                            Helps people execute their <br />bright ideas
                        </p>
                    </div>
                    <div class="sm:w-1/4 h-auto">
                        <div class="mb-8 font-bold">Explore</div>
                        <ul class="font-light">
                            <li class="mb-3">Our Services</li>
                            <li class="mb-3">Equity System</li>
                            <li class="mb-3">Refund</li>
                            <li class="mb-3">Shareholder</li>
                        </ul>
                    </div>
                    <div class="sm:w-1/4 h-auto">
                        <div class="mb-8 font-bold">Investor</div>
                        <ul class="font-light">
                            <li class="mb-3">My Account</li>
                            <li class="mb-3">Top Startups</li>
                            <li class="mb-3">How-to Tutorials</li>
                            <li class="mb-3">Withdrawl</li>
                        </ul>
                    </div>
                    <div class="sm:w-1/4 h-auto">
                        <div class="mb-8 font-bold">Office</div>
                        <ul class="font-light">
                            <li class="mb-3">+021 2208 1996</li>
                            <li class="mb-3">KBP, Bandung</li>
                            <li class="mb-3">No.12 (Backer)</li>
                            <li class="mb-3">support@backer.id</li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
import Navbar from "../../components/Navbar";
import useUser from "../../composables/user";
import {onMounted} from "vue";
export default {
    name: "Index",
    components: {Navbar},
    setup() {
        const { campaigns, getCampaigns } = useUser()

        onMounted(getCampaigns)

        return {
            campaigns,
            getCampaigns
        }
    },
}
</script>

<style scoped>

</style>

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
                <div class="w-full lg:max-w-full lg:flex mb-4">
                    <div
                        class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
                        style="background-color: #bbb"
                    ></div>
                    <div
                        class="w-full border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-8 flex flex-col justify-between leading-normal"
                    >
                        <div>
                            <div class="text-gray-900 font-bold text-xl mb-1">
                                Cari Uang Buat Gunpla
                            </div>
                            <p class="text-sm text-gray-600 flex items-center mb-2">
                                Rp. 200.000.000 &middot; 12 September 2020
                            </p>
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

export default {
    name: "Transactions",
    components: { Navbar, Footer },
}
</script>

<style scoped>

</style>

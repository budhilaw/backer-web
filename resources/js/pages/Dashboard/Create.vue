<template>
    <div class="project-page bg-purple-progress">
        <Navbar />
        <section class="container mx-auto pt-8 relative">
            <div class="flex justify-between items-center">
                <div class="w-full mr-6">
                    <h2 class="text-4xl text-white mb-2 font-medium">Dashboard</h2>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div class="w-3/4 mr-6">
                    <h3 class="text-2xl text-white mb-4">Create New Projects</h3>
                </div>
            </div>

            <div class="block mb-2">
                <div class="w-full lg:max-w-full lg:flex mb-4">
                    <div class="w-full border border-gray-400 bg-white rounded p-8 flex flex-col justify-between leading-normal">
                        <div class="w-full">
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                        Campaign Name
                                    </label>
                                    <input
                                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        type="text"
                                        v-model="form.name"
                                        placeholder="Contoh: Mechanical Keyboard"
                                    />
                                </div>
                                <div class="w-full md:w-1/2 px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                        Goal Amount
                                    </label>
                                    <input
                                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        type="number"
                                        v-model="form.goal_amount"
                                        placeholder="Contoh: 200000"
                                    />
                                </div>
                                <div class="w-full px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-3">
                                        Short Description
                                    </label>
                                    <input
                                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        type="text"
                                        v-model="form.excerpt"
                                        placeholder="Deskripsi singkat mengenai projectmu"
                                    />
                                </div>
                                <div class="w-full px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                        What will backers get
                                    </label>
                                    <input
                                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        type="text"
                                        v-model="form.perks"
                                        placeholder="Contoh: Ayam, Nasi Goreng, Piring (wajib menggunakan koma)"
                                    />
                                </div>
                                <div class="w-full px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                        Description
                                    </label>
                                    <textarea
                                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        type="text"
                                        v-model="form.description"
                                        placeholder="Isi deskripsi panjang untuk projectmu"
                                    ></textarea>
                                </div>
                                <div class="w-full px-3">
                                        <button @click="storeCampaign"
                                           class="bg-green-button hover:bg-green-button text-white font-bold px-4 py-1 rounded inline-flex items-center">
                                            Create
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
import { reactive, inject } from "vue";

export default {
    name: "CreateCampaign",
    components: { Navbar, Footer },
    setup() {
        const campaignStore = inject('campaignStore')

        let form = reactive({
            'name': "",
            'excerpt': '',
            'description': '',
            'perks': '',
            'goal_amount': '',
            'backer_count': 0,
            'current_amount': 0
        })

        const storeCampaign = () => {
            campaignStore.methods.createCampaign({...form})
        }

        return {
            form,
            campaignStore,
            storeCampaign
        }
    },
}
</script>

<style scoped>

</style>

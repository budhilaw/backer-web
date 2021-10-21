<template>
    <Navbar />
    <section class="container project-container mx-auto -mt-56">
        <div class="flex mt-3">
            <div class="w-3/4 mr-6">
                <div class="bg-white p-3 mb-3 border border-gray-400 rounded-20">
                    <figure class="item-image">
                        <img
                            src="/images/project-image.jpg"
                            alt=""
                            class="rounded-20 w-full"
                        />
                    </figure>
                </div>
                <div class="flex -mx-2">
                    <div class="relative w-1/4 bg-white m-2 p-2 border border-gray-400 rounded-20">
                        <figure class="item-thumbnail cursor-pointer">
                            <img
                                src="/images/project-slider-1.jpg"
                                alt=""
                                class="rounded-20 w-full"
                            />
                        </figure>
                    </div>
                    <div class="relative w-1/4 bg-white m-2 p-2 border border-gray-400 rounded-20">
                        <figure class="item-thumbnail cursor-pointer">
                            <img
                                src="/images/project-slider-2.jpg"
                                alt=""
                                class="rounded-20 w-full"
                            />
                        </figure>
                    </div>
                    <div class="relative w-1/4 bg-white m-2 p-2 border border-gray-400 rounded-20">
                        <figure class="item-thumbnail cursor-pointer">
                            <img
                                src="/images/project-slider-3.jpg"
                                alt=""
                                class="rounded-20 w-full"
                            />
                        </figure>
                    </div>
                    <div class="relative w-1/4 bg-white m-2 p-2 border border-gray-400 rounded-20">
                        <figure class="item-thumbnail cursor-pointer">
                            <img
                                src="/images/project-slider-4.jpg"
                                alt=""
                                class="rounded-20 w-full"
                            />
                        </figure>
                    </div>
                </div>
            </div>
            <div class="w-1/4">
                <div
                    class="bg-white w-full p-5 border border-gray-400 rounded-20 sticky"
                    style="top: 15px"
                >
                    <h3>Project Leader:</h3>

                    <div class="flex mt-3">
                        <div class="w-1/4">
                            <img
                                src="/testimonial-1-icon.png"
                                alt=""
                                class="w-full inline-block rounded-full"
                            />
                        </div>
                        <div class="w-3/4 ml-5 mt-1">
                            <div class="font-semibold text-xl text-gray-800">
                                Julia Keeva
                            </div>
                            <div class="font-light text-md text-gray-400">
                                28.093 backer
                            </div>
                        </div>
                    </div>

                    <h4 class="mt-5 font-semibold">What will you get:</h4>
                    <ul class="list-check mt-3">
                        <li>Equity of the startup directly from the founder</li>
                        <li>Special service or product that startup has</li>
                        <li>
                            You can also sell your equity once the startup going IPO
                        </li>
                    </ul>
                    <input
                        type="number"
                        class="border border-gray-500 block w-full px-6 py-3 mt-4 rounded-full text-gray-800 transition duration-300 ease-in-out focus:outline-none focus:shadow-outline"
                        placeholder="Amount in Rp"
                        value=""
                    />
                    <a
                        href="/fund-success.html"
                        class="text-center mt-3 button-cta block w-full bg-orange-button hover:bg-green-button text-white font-medium px-6 py-3 text-md rounded-full"
                    >
                        Fund Now
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="container mx-auto pt-8">
        <div class="flex justify-between items-center">
            <div class="w-full md:w-3/4 mr-6">
                <h2 class="text-4xl text-gray-900 mb-2 font-medium">
                    {{ campaign.name }}
                </h2>
                <p class="font-light text-xl mb-5">
                    {{ campaign.excerpt }}
                </p>

                <base-progress :percentage="(campaign.current_amount / campaign.goal_amount)*100" />

                <div class="flex progress-info mb-6">
                    <div class="text-2xl">{{ (campaign.current_amount / campaign.goal_amount)*100 }}%</div>
                    <div class="ml-auto font-semibold text-2xl">Rp. {{ campaign.goal_amount }}</div>
                </div>

                <p class="font-light text-xl mb-5">
                    {{ campaign.description }}
                </p>
            </div>
            <div class="w-1/4 hidden md:block"></div>
        </div>
    </section>
    <div class="cta-clip -mt-20"></div>
    <section class="call-to-action bg-purple-progress pt-64 pb-10">
        <div class="container mx-auto">
            <div class="w-full text-center">
                <h1 class="text-5xl text-white font-semibold">
                    Easy way to funding
                    <br />
                    best idea and innovation
                </h1>
                <button
                    @click="$router.push({ path: '/upload' })"
                    class="inline-block bg-orange-button hover:bg-green-button text-white font-semibold px-6 py-4 mt-8 text-lg rounded-full"
                >
                    Getting Start
                </button>
            </div>
        </div>
    </section>
    <Footer />
</template>

<script>
import useCampaign from "../composables/campaign";
import Navbar from "../components/Navbar";
import BaseProgress from "../components/BaseProgress";
import {onMounted} from "vue";
import Footer from "../components/Footer";

export default {
    name: "SingleCampaign",
    props: {
        slug: {
            required: true,
            type: String
        }
    },
    components: {Footer, Navbar, BaseProgress},
    setup(props) {

        const { campaign, getCampaignBySlug } = useCampaign()

        onMounted(getCampaignBySlug(props.slug))

        return {
            campaign,
            getCampaignBySlug
        }
    },
}
</script>

<style scoped>

</style>

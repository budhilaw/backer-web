<template>
    <div class="landing-page">
        <Navbar hero="true" />
        <section class="container mx-auto pt-24">
            <div class="flex justify-between items-center mb-10">
                <div class="w-auto">
                    <h2 class="text-3xl text-gray-900 mb-8">
                        Only 3 steps to execute <br />
                        your bright ideas
                    </h2>
                </div>
            </div>
            <div class="flex">
                <div class="w-full px-56 mb-5">
                    <img src="/images/line-step.svg" alt="" class="w-full" />
                </div>
            </div>
            <div class="flex justify-between items-center text-center">
                <div class="w-1/3">
                    <figure class="flex justify-center items-center">
                        <img src="/images/step-1-illustration.svg" alt="" class="h-30 mb-8" />
                    </figure>
                    <div class="step-content">
                        <h3 class="font-medium">Sign Up</h3>
                        <p class="font-light">
                            Sign Up account and start <br />funding project
                        </p>
                    </div>
                </div>
                <div class="w-1/3">
                    <figure class="flex justify-center items-center -mt-24">
                        <img src="/images/step-2-illustration.svg" alt="" class="h-30 mb-8" />
                    </figure>
                    <div class="step-content">
                        <h3 class="font-medium">Open Project</h3>
                        <p class="font-light">
                            Choose some project idea, <br />
                            and start funding
                        </p>
                    </div>
                </div>
                <div class="w-1/3">
                    <figure class="flex justify-center items-center -mt-48">
                        <img src="/images/step-3-illustration.svg" alt="" class="h-30 mb-8" />
                    </figure>
                    <div class="step-content">
                        <h3 class="font-medium">Execute</h3>
                        <p class="font-light">
                            Time to makes dream <br />
                            comes true
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section class="container mx-auto pt-24">
            <div class="flex justify-between items-center">
                <div class="w-auto">
                    <h2 class="text-3xl text-gray-900 mb-8">
                        New projects you can <br />
                        taken care of
                    </h2>
                </div>
                <div class="w-auto mt-5">
                    <router-link class="text-gray-900 hover:underline text-md font-medium"
                                 to="/campaign"
                    >View All</router-link>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div class="w-full p-5 border border-gray-500 rounded-20"
                     v-for="item in campaignStore.state.campaigns" :key="item.id">
                    <div class="item">
                        <figure class="item-image">
                            <img
                                :src="baseURL + item?.image?.file_name"
                                alt=""
                                class="rounded-20 w-full"
                            />
                        </figure>
                        <div class="item-meta">
                            <h4 class="text-3xl font-medium text-gray-900 mt-5 truncate">
                                {{ item.name }}
                            </h4>
                            <p class="text-md font-light text-gray-900 my-4 truncate">
                                {{ item.excerpt }}
                            </p>
                            <BaseProgress :percentage="(item.current_amount / item.goal_amount)*100" />
                            <div class="flex progress-info">
                                <div>{{ (item.current_amount / item.goal_amount)*100 }}%</div>
                                <div class="ml-auto font-semibold">Rp. {{ item.goal_amount }}</div>
                            </div>
                        </div>
                        <router-link class="mt-5 text-center button-cta block w-full bg-orange-button hover:bg-green-button text-white font-semibold px-6 py-2 text-lg rounded-full"
                                     :to="{ name: 'SingleCampaign', params: { slug: item.slug } }"
                        >Fund Now</router-link>
                    </div>
                </div>
            </div>
        </section>
        <section class="container mx-auto pt-24">
            <div class="flex justify-between items-center">
                <div class="w-auto">
                    <h2 class="text-3xl text-gray-900 mb-8">
                        See What Our <br />
                        Happy Clients Say
                    </h2>
                </div>
            </div>
            <div class="flex mb-10">
                <div class="w-2/12 flex justify-center items-start">
                    <img src="/images/testimonial-line.svg" alt="" />
                </div>
                <div class="w-8/12 mt-16">
                    <h2 class="text-3xl text-gray-900 font-light">
                        “Funding at Bucker is very easy and comfortable. <br />
                        Just need to find an idea, click and already funding.”
                    </h2>
                    <div class="testimonial-info mt-8">
                        <div class="name text-xl font-semibold">Shopie Nicole</div>
                        <div class="title text-xl font-light text-gray-400">
                            Project Manager
                        </div>
                    </div>
                    <div class="testimonial-icon mt-10">
                        <img
                            src="/images/testimonial-1-icon.png"
                            alt=""
                            class="w-20 mr-5 inline-block testimonial-user rounded-full"
                        />
                        <img
                            src="/images/testimonial-2-icon.png"
                            alt=""
                            class="w-20 mr-5 inline-block testimonial-user rounded-full"
                        />
                        <img
                            src="/images/testimonial-3-icon.png"
                            alt=""
                            class="w-20 mr-5 inline-block testimonial-user active rounded-full"
                        />
                    </div>
                </div>
                <div class="w-2/12"></div>
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
    </div>
</template>

<script>
import Hero from "../components/Hero";
import {onMounted, inject, computed} from "vue";
import Footer from "../components/Footer";
import BaseProgress from "../components/BaseProgress";
import Navbar from "../components/Navbar";

export default {
    components: {Navbar, BaseProgress, Footer, Hero},
    name: "Home",
    setup() {
        const campaignStore = inject('campaignStore')

        onMounted(() => {
            campaignStore.methods.visitorCampaigns()
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

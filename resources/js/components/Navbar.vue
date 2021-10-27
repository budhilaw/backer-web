<template>
    <section class="landing-hero pt-5">
        <div class="header__bg"></div>
        <div class="container mx-auto relative">
            <NavLinks />
            <div v-if="hero" class="flex items-center pt-10 px-5 md:px-0">
                <div class="w-1/2">
                    <h1 class="text-4xl text-white mb-5">
                        We helps <u class="hero-underline">startup</u> to <br />
                        getting started & <u class="hero-underline">funding</u> <br />
                        their truly needs
                    </h1>
                    <p class="text-white text-xl font-light mb-8">
                        Fund the best idea to become <br />
                        a real product and be the contributor
                    </p>
                    <button
                        @click="$router.push({ path: '/' })"
                        class="block bg-orange-button hover:bg-green-button text-white font-semibold px-12 py-3 text-xl rounded-full"
                    >
                        Find a Project
                    </button>
                </div>
                <div class="w-1/2 flex justify-center">
                    <img src="/images/hero-image@2x.png" alt="crowdfunding project" />
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import NavLinks from "./NavLinks";
export default {
    name: "Navbar",
    props: ['hero'],
    components: {NavLinks}
}
</script>

import { createRouter, createWebHistory } from "vue-router"
import NotFound from './pages/NotFound'
import Home from './pages/Home'
import About from "./pages/About";
import SingleCampaign from "./pages/SingleCampaign";

const routes = [
    {
        path: '/',
        component: Home,
        name: "Home"
    },
    {
        path: '/about',
        component: About,
        name: "About"
    },
    {
        path: '/campaign/:slug',
        component: SingleCampaign,
        name: "SingleCampaign",
        props: true
    },
    {
        path: '/:catchAll(.*)',
        component: NotFound,
        name: "NotFound"
    }
]

const router = createRouter({
    scrollBehavior(to, from, savedPosition) {
        return { top: 0 }
    },
    history: createWebHistory(),
    routes
})

export default router

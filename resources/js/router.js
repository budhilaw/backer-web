import { createRouter, createWebHistory } from "vue-router"
import NotFound from './pages/NotFound'
import Home from './pages/Home'
import About from "./pages/About";
import SingleCampaign from "./pages/SingleCampaign";
import Register from "./pages/Register";
import Login from "./pages/Login";
import Logout from "./pages/Logout";

import Dashboard from "./pages/Dashboard/Index";

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
        path: '/register',
        component: Register,
        name: "Register"
    },
    {
        path: '/login',
        component: Login,
        name: "Login"
    },
    {
        path: '/logout',
        component: Logout,
        name: "Logout"
    },
    {
        path: '/dashboard',
        component: Dashboard,
        name: "Dashboard"
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

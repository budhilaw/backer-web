import { createApp } from "vue"
import App from "./components/App";
import router from './router'

require('./bootstrap');

createApp(App)
    .use(router)
    .mount("#app");

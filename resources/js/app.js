import { createApp } from "vue"
import App from "./components/App";
import router from './router'
import { library } from '@fortawesome/fontawesome-svg-core';
import { faTrash, faThumbtack, faPlusCircle } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(faTrash, faThumbtack, faPlusCircle)

require('./bootstrap');

createApp(App)
    .use(router)
    .component('font-awesome-icon', FontAwesomeIcon)
    .mount("#app");

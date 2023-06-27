import './bootstrap';
// import '../../node_modules/flowbite/dist/flowbite.js'ss
import { createApp } from 'vue';
import App from './Layouts/App.vue';
import router from './router.js'

createApp(App)
    .use(router)
        .mount("#app");

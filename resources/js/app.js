import { createApp } from "vue";
import router from "./router";
import Index from "./components/Index.vue";
import "./bootstrap";
import { createPinia } from "pinia";
const app = createApp({
    components: {
        Index,
    },
});

const pinia = createPinia();

app.use(router);
app.use(pinia);

app.mount("#app");

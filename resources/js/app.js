import { createApp } from "vue";
import router from "./router";
import Index from "./components/Index.vue";
import "./bootstrap";
const app = createApp({
    components: {
        Index,
    },
});
app.use(router);
app.mount("#app");

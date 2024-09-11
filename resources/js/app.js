import { createApp } from "vue";
import router from "./app/router";
import AppLayout from "./app/AppLayout.vue";

createApp(AppLayout).use(router).mount("#root");

import { createMemoryHistory, createRouter } from "vue-router";

const routes = [
    { path: "/", component: () => import("resources/js/pages/HomePage.vue") },
];

export default createRouter({
    history: createMemoryHistory(),
    routes,
});

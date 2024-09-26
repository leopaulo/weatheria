import { createWebHistory, createRouter } from "vue-router";

const routes = [
    { path: "/", component: () => import("resources/js/pages/HomePage.vue") },
    {
        path: "/search/:city",
        component: () => import("resources/js/pages/SearchPage.vue"),
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});

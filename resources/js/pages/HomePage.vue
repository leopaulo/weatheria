<template>
    <div class="h-full w-full flex justify-center flex-col items-center">
        <div class="logo">
            <AppLogo />
        </div>
        <SearchBox />
        <div class="suggestion flex flex-wrap">
            <div
                class="rounded-full flex w-1/2 md:w-1/3 p-2 text-teal-100"
                v-for="(linkItem, index) in quickLinks"
                :key="index"
            >
                <RouterLink
                    class="text-center border-2 w-full border-teal-100 rounded-full"
                    :to="linkItem.route"
                    >{{ linkItem.label }}</RouterLink
                >
            </div>
        </div>
    </div>
</template>
<script setup>
import AppLogo from "resources/js/components/AppLogo.vue";
import SearchBox from "resources/js/components/SearchBox.vue";
import "./HomePage.css";
import { ref } from "vue";

const quickLinks = ref([
    {
        label: "Tokyo",
        route: "/search/tokyo",
    },
    {
        label: "Yokohama",
        route: "/search/yokohama",
    },
    {
        label: "Kyoto",
        route: "/search/kyoto",
    },
    {
        label: "Osaka",
        route: "/search/osaka",
    },
    {
        label: "Sapporo",
        route: "/search/sapporo",
    },
    {
        label: "Nagoya",
        route: "/search/nagoya",
    },
]);
</script>

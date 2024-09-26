<template>
    <div class="min-h-full flex flex-wrap flex-col pb-5 pt-2">
        <div class="flex flex-row">
            <div class="flex p-2 flex-grow">
                <div @click="goToRoot" class="cursor-pointer flex">
                    <AppLogo />
                </div>
            </div>
            <div class="flex p-2">
                <SearchBox class="search-box" />
            </div>
        </div>
        <WeatherForecast />
        <NearbyPlace />
    </div>
</template>
<script setup>
import { useRouter } from "vue-router";
import WeatherForecast from "./searchpage/WeatherForecast.vue";
import NearbyPlace from "./searchpage/NearbyPlace.vue";
import AppLogo from "resources/js/components/AppLogo.vue";
import SearchBox from "resources/js/components/SearchBox.vue";
import "./SearchPage.css";

let router = useRouter();

function goToRoot() {
    router.push("/");
}
</script>

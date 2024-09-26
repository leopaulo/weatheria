<template>
    <div v-if="data.length > 0" class="w-full flex pt-3 px-5 flex-wrap">
        <div
            v-for="(item, index) in data"
            :key="index"
            class="small-item md:item"
        >
            <div
                class="rounded border-2 border-white w-full flex-grow flex-col flex border-opacity-50"
            >
                <div class="text-center p-1 text-xs">
                    {{ customTimeFormat(item.time) }}
                </div>
                <img :src="weatherIcon(item.icon, 1)" class="w-full" />
            </div>
        </div>
    </div>
</template>
<script setup>
import { weatherIcon } from "/resources/js/utils/weather";
import { formatTimeString } from "/resources/js/utils/dateTime";
import "./HourlyForecast.css";

function customTimeFormat(time) {
    return formatTimeString(time, {
        hour12: true,
        hour: "numeric",
    });
}

defineProps(["data"]);
</script>

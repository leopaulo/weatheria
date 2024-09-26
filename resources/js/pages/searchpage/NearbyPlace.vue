<template>
    <div class="flex flex-grow mx-auto w-full max-w-2xl p-5 text-gray-800">
        <div
            class="flex flex-grow w-full bg-white rounded-2xl flex-wrap flex-col"
        >
            <h1
                class="text-xl pt-3 px-5 flex flex-row justify-center align-middle"
            >
                <div class="flex">
                    <svg
                        class="h-8 w-8"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                    </svg>
                </div>
                <div class="flex pl-2">
                    Great places in
                    <span class="capitalize text-bold pl-2">{{
                        `${route.params.city}`
                    }}</span>
                </div>
            </h1>
            <LoadingDisplay v-if="isLoading" />
            <ErrorDisplay v-else-if="isError" />
            <div v-else class="pt-3">
                <div
                    v-for="(placeItem, index) in placeList"
                    :key="index"
                    class="p-5 py-3 border-gray-200 border-t-2"
                >
                    <div class="flex flex-col">
                        <div class="opacity-60 text-xs flex flex-row">
                            <div
                                v-for="(
                                    categoryItem, categoryIndex
                                ) in placeItem.categories"
                                :key="categoryIndex"
                                class="pr-3"
                            >
                                &#x2022; {{ categoryItem }}
                            </div>
                        </div>
                        <div class="font-bold">
                            {{ placeItem.name }}
                        </div>
                        <div class="opacity-80 text-sm">
                            {{ placeItem.address }}
                        </div>
                        <div>
                            <a
                                class="text-blue-700 text-sm flex"
                                target="_blank"
                                :href="`https://www.google.com/maps/search/?api=1&query=${placeItem.geocodes.latitude},${placeItem.geocodes.longitude}`"
                            >
                                <svg
                                    class="h-5 w-5 mr-2"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <line x1="18" y1="6" x2="18" y2="6.01" />
                                    <path
                                        d="M18 13l-3.5 -5a4 4 0 1 1 7 0l-3.5 5"
                                    />
                                    <polyline
                                        points="10.5 4.75 9 4 3 7 3 20 9 17 15 20 21 17 21 15"
                                    />
                                    <line x1="9" y1="4" x2="9" y2="17" />
                                    <line x1="15" y1="15" x2="15" y2="20" />
                                </svg>
                                Click Here For Direction</a
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import LoadingDisplay from "./nearbyplace/LoadingDisplay.vue";
import ErrorDisplay from "./nearbyplace/ErrorDisplay.vue";
import { getNearbyPlace } from "resources/js/ajax/backend";
let route = useRoute();

let isError = ref(false);
let placeList = ref([]);
let isLoading = ref(true);

onMounted(() => {
    getNearbyPlace(route.params.city)
        .then(({ data: { data } }) => {
            placeList.value = data;
            isLoading.value = false;
        })
        .catch(() => {
            isError.value = true;
            isLoading.value = false;
        });
});
</script>

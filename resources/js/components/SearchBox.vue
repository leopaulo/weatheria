<template>
    <form
        @submit="goToSearch"
        class="flex p-5 w-full min-w-0 max-w-md relative"
    >
        <input
            class="search-input text-gray-800"
            placeholder="Enter Japan City Name e.g. Tokyo, Osaka... "
            v-model="city"
        />
        <button class="search-icon" type="submit">
            <svg
                class="h-5 w-5 text-gray-800"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
        </button>
        <div class="search-result" v-if="city.trim() != ''">
            <div class="bg-white rounded-b h-full overflow-auto">
                <div v-if="filteredCityList.length <= 0">
                    <div class="p-2 cursor-pointer italic opacity-60">
                        No city found
                    </div>
                </div>
                <div v-else class="flex flex-col">
                    <RouterLink
                        class="p-2 capitalize border-b-2 border-gray-200 cursor-pointer"
                        v-for="cityItem in filteredCityList"
                        :key="cityItem"
                        :to="`/search/${cityItem}`"
                        @click="clearSearch"
                    >
                        {{ cityItem }}
                    </RouterLink>
                </div>
            </div>
        </div>
    </form>
</template>

<script setup>
import { ref, computed } from "vue";
import "./SearchBox.css";
import cityListStore from "resources/js/stores/cityList";

let city = ref("");

let filteredCityList = computed(() =>
    city.value.trim() != ""
        ? cityListStore.cities.filter(
              (item) =>
                  item.toLowerCase().indexOf(city.value.toLowerCase()) > -1,
          )
        : [],
);

function goToSearch(event) {
    event.preventDefault();
}

function clearSearch() {
    city.value = "";
}
</script>

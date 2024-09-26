<template>
    <LoadingDisplay v-if="isLoadingWeather" />
    <ErrorDisplay v-else-if="isWeatherError" />
    <div class="flex mx-auto w-full max-w-2xl md:p-5 p-2 flex-wrap" v-else>
        <div
            class="flex flex-wrap md:flex-col flex-row md:justify-end md:px-7 p-5 flex-grow"
        >
            <div class="md:text-5xl text-lg capitalize">
                {{ route.params.city }},
            </div>
            <div class="flex flex-row text-lg opacity-60">
                <div class="md:pt-2 pl-2">
                    {{ selectedDateShortText }},
                    {{ selectedDate }}
                    {{ selectedWeatherCurrentTime.time }}
                </div>
            </div>
        </div>
        <div
            class="flex flex-wrap justify-end flex-col text-5xl md:px-7 p-5 w-1/2 md:w-auto"
        >
            {{ kelvinToCelsius(selectedWeatherCurrentTime.temp) }}&deg;C
            <div class="flex flex-row text-lg opacity-60">
                <div class="pr-2">
                    &darr;
                    {{
                        kelvinToCelsius(selectedWeatherCurrentTime.tempMin)
                    }}&deg;
                </div>
                <div>
                    &uarr;
                    {{
                        kelvinToCelsius(selectedWeatherCurrentTime.tempMax)
                    }}&deg;
                </div>
            </div>
        </div>
        <div
            class="flex flex-wrap justify-end flex-col md:px-7 w-1/2 p-5 md:w-auto"
        >
            <div>
                <div class="md:weatherImageContainer weatherImageSmall">
                    <img
                        class="weatherImage"
                        :src="weatherIcon(selectedWeatherCurrentTime.icon)"
                    />
                </div>
            </div>
            <div class="opacity-60 text-sm pt-2 text-center capitalize">
                {{ selectedWeatherCurrentTime.description }}
            </div>
        </div>
        <HourlyForecast :data="selectedWeatherOtherTime" />
        <div class="flex w-full flex-row px-5">
            <div class="flex w-1/2">
                <button v-if="selectedWeatherIndex > 0" @click="previousDay">
                    &#60; Previous Day
                </button>
            </div>
            <div class="flex items-end w-1/2 flex-col">
                <button
                    @click="nextDay"
                    v-if="selectedWeatherIndex < weatherDataLength"
                >
                    Next Day &#62;
                </button>
            </div>
        </div>
    </div>
</template>
<script setup>
import { onMounted, ref, computed } from "vue";
import { getWeather } from "resources/js/ajax/backend";
import { useRoute } from "vue-router";
import { kelvinToCelsius, weatherIcon } from "resources/js/utils/weather";
import HourlyForecast from "./weatherforecast/HourlyForecast.vue";
import LoadingDisplay from "./weatherforecast/LoadingDisplay.vue";
import "./WeatherForecast.css";
import ErrorDisplay from "./weatherforecast/ErrorDisplay.vue";

let route = useRoute();

let isLoadingWeather = ref(true);
let weatherData = ref([]);
let isWeatherError = ref(false);
let selectedWeatherIndex = ref(0);

let weatherDataLength = computed(() => {
    return weatherData.value.length;
});

let selectedWeatherCurrentTime = computed(() => {
    return weatherDataLength.value > 0
        ? weatherData.value[selectedWeatherIndex.value]["list"][0]
        : {};
});

let selectedDate = computed(() => {
    return weatherDataLength.value > 0
        ? weatherData.value[selectedWeatherIndex.value]["date"]
        : "";
});

let selectedDateShortText = computed(() => {
    return weatherDataLength.value > 0
        ? weatherData.value[selectedWeatherIndex.value]["dateShortText"]
        : "";
});

let selectedWeatherOtherTime = computed(() => {
    return weatherDataLength.value > 0
        ? weatherData.value[selectedWeatherIndex.value]["list"].filter(
              (_, index) => index > 0,
          )
        : [];
});

function previousDay() {
    selectedWeatherIndex.value--;
}

function nextDay() {
    selectedWeatherIndex.value++;
}

onMounted(() => {
    getWeather(route.params.city)
        .then(({ data: { data } }) => {
            weatherData.value = data;
            isLoadingWeather.value = false;
        })
        .catch(() => {
            isWeatherError.value = true;
            isLoadingWeather.value = false;
        });
});
</script>

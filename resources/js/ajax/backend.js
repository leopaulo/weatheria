import axios from "axios";
import {
    subscribe,
    unsubscribe,
    responseInterceptor,
} from "./backend/responseInterceptor";
import { autoAddCsrfToken } from "./backend/csrfToken";
import defaultRequestHeaders from "./backend/defaultRequestHeaders";

let axiosInstance = axios.create({
    baseURL: "",
});

defaultRequestHeaders(axiosInstance);
autoAddCsrfToken(axiosInstance);
responseInterceptor(axiosInstance);

export { subscribe, unsubscribe };

export function getWeather(city) {
    return axiosInstance({
        url: "/get-weather",
        method: "post",
        data: { city },
    });
}

export function getNearbyPlace(city) {
    return axiosInstance({
        url: "/get-nearby-place",
        method: "post",
        data: { city },
    });
}

export function getCityList(city) {
    return axiosInstance({
        url: "/get-city-list",
        method: "post",
        data: { city },
    });
}

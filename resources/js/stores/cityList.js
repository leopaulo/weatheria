import { reactive } from "vue";
import { getCityList } from "resources/js/ajax/backend";

let store = reactive({
    cities: [],
    isLoading: true,
    init() {
        getCityList().then(({ data: { data } }) => {
            this.cities = data;
            this.isLoading = false;
        });
    },
});

store.init();

export default store;

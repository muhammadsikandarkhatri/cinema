import Vue from "vue";
import App from "./components/App";
import router from "./router";
import store from "./store";
import axios from "axios";
import JwPagination from 'jw-vue-pagination';
import Datepicker from 'vuejs-datepicker';
import VueMoment from 'vue-moment';

/**
 * Inject Dependencies
 */
Vue.use(VueMoment);

Vue.config.productionTip = false;

axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response.status === 422) {
            store.commit("setErrors", error.response.data.errors);
        } else if (error.response.status === 401) {
            store.commit("auth/setUserData", null);
            localStorage.removeItem("authToken");
            router.push({ name: "Login" });
        } else {
            return Promise.reject(error);
        }
    }
);

axios.interceptors.request.use(function(config) {
    config.headers.common = {
        Authorization: `Bearer ${localStorage.getItem("authToken")}`,
        "Content-Type": "application/json",
        Accept: "application/json"
    };

    return config;
});

/**
 * register components globally
 */
Vue.component('jw-pagination', JwPagination);
Vue.component('datepicker', Datepicker);

/**
 * Initialize App
 */
new Vue({
    router,
    store,
    render: h => h(App)
}).$mount("#app");

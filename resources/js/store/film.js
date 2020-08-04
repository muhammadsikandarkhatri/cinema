import axios from "axios";

export default {
    namespaced: true,

    state: {
        filmData: {},
        filmCollectionData: {},
        countryCollectionData: {},
        pagination: [],
    },

    getters: {
        filmData: state => state.filmData,
        filmCollectionData: state => state.filmCollectionData,
        countryCollectionData: state => state.countryCollectionData,
        pagination: state => state.pagination,
    },

    mutations: {
        setFilmData(state, film) {
            state.filmData = film;
        },
        setFilmCollectionData(state, films) {
            state.filmCollectionData = films;
        },
        setCountryCollectionData(state, countries) {
            state.countryCollectionData = countries;
        },
        setPagination(state, pagination) {
            state.pagination = pagination;
        },
    },

    actions: {
        getFilmData({commit}, slug) {
            axios
                .get(process.env.MIX_VUE_APP_API_URL + "/films/" + slug)
                .then(response => {
                    commit("setFilmData", response.data);
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getFilmCollectionData({commit}, url) {
            axios
                .get(url)
                .then(response => {
                    commit("setFilmCollectionData", response.data);
                    /**
                     * Make Pagination
                     */
                    commit("setPagination", {
                        current_page: response.data.meta.current_page,
                        last_page: response.data.meta.last_page,
                        prev_page_url: response.data.links.prev,
                        next_page_url: response.data.links.next,
                    });
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getCountriesCollectionData({commit}) {
            axios
                .get(process.env.MIX_VUE_APP_API_URL + "/countryList")
                .then(response => {
                    commit("setCountryCollectionData", response.data);
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        createFilmRequest({commit}, data) {
            commit("setErrors", {}, {root: true});
            return axios
                .post(process.env.MIX_VUE_APP_API_URL + "/films", data)
                .then(response => {
                    commit("setFilmData", response.data);
                });
        },
        deleteFilmRequest({commit}, id) {
            commit("setErrors", {}, {root: true});
            return axios
                .post(process.env.MIX_VUE_APP_API_URL + "/films/" + id)
                .then(response => {
                    commit("setFilmData", null);
                });
        },
    }
};

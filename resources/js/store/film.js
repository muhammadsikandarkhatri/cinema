import axios from "axios";

export default {
    namespaced: true,

    state: {
        filmData: {},
        filmCollectionData: {},
        countryCollectionData: {},
    },

    getters: {
        filmData: state => state.filmData,
        filmCollectionData: state => state.filmCollectionData,
        countryCollectionData: state => state.countryCollectionData,
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
    },

    actions: {
        getFilmData({commit}, slug) {
            axios
                .get(process.env.MIX_VUE_APP_API_URL + "films/" + slug)
                .then(response => {
                    commit("setFilmData", response.data);
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getFilmCollectionData({commit}) {
            axios
                .get(process.env.MIX_VUE_APP_API_URL + "films")
                .then(response => {
                    commit("setFilmCollectionData", response.data);
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getCountriesCollectionData({commit}) {
            axios
                .get(process.env.MIX_VUE_APP_API_URL + "countryList")
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
                .post(process.env.MIX_VUE_APP_API_URL + "films", data)
                .then(response => {
                    commit("setFilmData", response.data);
                });
        },
        deleteFilmRequest({commit}, id) {
            commit("setErrors", {}, {root: true});
            return axios
                .post(process.env.MIX_VUE_APP_API_URL + "films/" + id)
                .then(response => {
                    commit("setFilmData", null);
                });
        }
    }
};

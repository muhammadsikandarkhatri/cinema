import axios from "axios";

export default {
  namespaced: true,

  state: {
    filmData: null,
    filmCollectionData: null
  },

  getters: {
    filmData: state => state.filmData,
    filmCollectionData: state => state.filmCollectionData,
  },

  mutations: {
    setFilmData(state, film) {
      state.filmData = film;
    },
    setFilmCollectionData(state, films) {
      state.filmCollectionData = films;
    }
  },

  actions: {
    getFilmData({ commit }, slug) {
      axios
        .get(process.env.MIX_VUE_APP_API_URL + "films/" + slug)
        .then(response => {
          commit("setFilmData", response.data);
        })
        .catch((err) => {
            console.log(err);
        });
    },
    getFilmCollectionData({ commit }) {
      axios
          .get(process.env.MIX_VUE_APP_API_URL + "films")
          .then(response => {
              commit("setFilmCollectionData", response.data);
          })
          .catch((err) => {
              console.log(err);
          });
    },
    createFilmRequest({ commit }, data) {
      commit("setErrors", {}, { root: true });
      return axios
        .post(process.env.MIX_VUE_APP_API_URL + "films", data)
        .then(response => {
          commit("setFilmData", response.data);
        });
    },
    deleteFilmRequest({ commit }, id) {
      commit("setErrors", {}, { root: true });
      return axios
        .post(process.env.MIX_VUE_APP_API_URL + "films/" + id)
        .then(response => {
          commit("setFilmData", null);
        });
    }
  }
};

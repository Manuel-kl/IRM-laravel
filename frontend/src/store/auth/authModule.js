import { api } from "@/utils/api.js";

const authModule = {
  namespaced: true,

  state: {
    errors: null,
    error: null,
    user: null,
  },
  actions: {
    async register({ commit }, user) {
      try {
        const response = await api.post("/new-user", {
          name: user.name,
          email: user.email,
          password: user.password,
        });
        const token = response.data.access_token;
        localStorage.setItem("access_token", token);
      } catch (error) {
        console.log(error);
        const errors = error.response.data.errors;
        const e = error.response.data.message;

        commit("setErrors", errors);
        commit("setError", e);

        setTimeout(() => {
          commit("setErrors", null);
          commit("setError", null);
        }, 5000);
      }
    },

    async login({ commit }, user) {
      try {
        const response = await api.post("/login", {
          email: user.email,
          password: user.password,
        });
        console.log(response.data);

        const token = response.data.access_token;
        localStorage.setItem("access_token", token);
      } catch (error) {
        const errors = error.response.data.errors;
        const e = error.response.data.message;

        commit("setErrors", errors);
        commit("setError", e);

        setTimeout(() => {
          commit("setErrors", null);
          commit("setError", null);
        }, 5000);
      }
    },

    async getUser({ commit }) {
      try {
        const token = localStorage.getItem("access_token");
        const response = await api.get("/user", {
          headers: {
            Authorization: "Bearer " + token,
          },
        });
        const user = response.data;

        commit("setUser", user);
      } catch (error) {
        localStorage.removeItem("access_token");
        console.log(error);
      }
    },
  },

  getters: {},

  mutations: {
    setErrors(state, errors) {
      state.errors = errors;
    },
    setError(state, error) {
      state.error = error;
    },
    setUser(state, user) {
      state.user = user;
    },
  },
};
export default authModule;

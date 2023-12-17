import { api } from "@/utils/api.js";

const adminsModule = {
  namespaced: true,

  state: {
    admins: [],
    admin: null,
    errors: null,
    error: null,
  },

  actions: {
    async addAdmin({ commit }, email) {
      try {
        const response = await api.post(
          `/admins`,
          {
            email: email,
          },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("access_token")}`,
            },
          }
        );
      } catch (error) {
        console.log(error);
      }
    },

    async getAdmins({ commit }) {
      try {
        const response = await api.get("/admins", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("access_token")}`,
          },
        });
        const users = response.data.data;
        console.log(response);
        commit("setAdmins", users);
      } catch (error) {
        const e = error.response.data.message;
        console.log(e);

        commit("setError", e);

        setTimeout(() => {
          commit("setError", null);
        }, 5000);
      }
    },

    async removeAdmin({ commit }, id) {
      try {
        const response = await api.delete(`/admins/${id}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("access_token")}`,
          },
        });
        console.log(response);
      } catch (error) {
        const e = error.response.data.message;
        console.log(e);
        commit("setError", e);

        setTimeout(() => {
          commit("setError", null);
        }, 5000);
      }
    },
  },

  mutations: {
    setAdmins(state, admins) {
      state.admins = admins;
    },

    setError(state, error) {
      state.error = error;
    },
  },
};

export default adminsModule;

import { api } from "@/utils/api.js";

const usersModule = {
  namespaced: true,

  state: {
    users: [],
    user: null,
  },

  actions: {
    async getUsers({ commit }) {
      try {
        const response = await api.get("/users", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("access_token")}`,
          },
        });
        const users = response.data.data;
        commit("setUsers", users);
      } catch (error) {
        console.log(error);
      }
    },

    async getUser({ commit }, id) {
      try {
        const response = await api.get(`/users/${id}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("access_token")}`,
          },
        });
        const user = response.data;
        console.log(user);
        commit("setUser", user);
      } catch (error) {
        console.log(error);
        const errors = error.response.data.errors;
        const e = error.response.data.message;
        commit("setErrors", errors);
      }
    },

    async deleteUser({ commit }, id) {
      try {
        await api.delete(`/users/${id}`);
        commit("deleteUser", id);
      } catch (error) {
        console.log(error);
      }
    },
  },

  mutations: {
    setUsers(state, users) {
      state.users = users;
    },

    setUser(state, user) {
      state.user = user;
    },
  },
};

export default usersModule;

import { api } from "@/utils/api.js";

const usersModule = {
  namespaced: true,

  state: {
    users: [],
    user: null,
    errors: null,
    error: null,
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

    async updateUser({ commit }, user) {
      try {
        const response = await api.put(
          `/users/${user.id}`,
          {
            name: user.name,
            email: user.email,
          },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("access_token")}`,
            },
          }
        );
        const updatedUser = response.data.data;
        console.log(response);
        commit("setUser", updatedUser);
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

    async deleteUser({ commit }, id) {
      try {
        await api.delete(`/users/${id}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("access_token")}`,
          },
        });
        commit("setUser", null);
        localStorage.removeItem("access_token");
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

    setErrors(state, errors) {
      state.errors = errors;
    },

    setError(state, error) {
      state.error = error;
    },
  },
};

export default usersModule;

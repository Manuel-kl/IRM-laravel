import { createStore } from "vuex";
import authModule from "./auth/authModule.js";
import usersModule from "./usersModule/usersModule.js";
import adminsModule from "./usersModule/adminsModule.js";

export default createStore({
  modules: {
    authModule: authModule,
    usersModule: usersModule,
    adminsModule: adminsModule,
  },
});

import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";

const routes = [
  {
    path: "/",
    name: "home",
    component: HomeView,
  },
  {
    path: "/login",
    name: "login",
    component: () => import("../views/Auth/LoginView.vue"),
  },
  {
    path: "/register",
    name: "register",
    component: () => import("../views/Auth/RegisterView.vue"),
  },
  {
    path: "/settings/:id",
    name: "settings",
    component: () => import("../views/Users/SettingsView.vue"),
  },
  {
    path: "/users",
    name: "users",
    component: () => import("../views/Users/UsersView.vue"),
  },
  {
    path: "/admins",
    name: "admins",
    component: () => import("../views/Users/AdminsView.vue"),
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {
  const loggedIn = localStorage.getItem("access_token");

  if (to.name !== "login" && !loggedIn && to.name !== "register") {
    // If the user is not logged in and tries to access any route other than 'login',
    // redirect to the login page
    next({ name: "login" });
  } else if ((to.name === "login" || to.name === "register") && loggedIn) {
    // If the user is already logged in and tries to access 'login' or 'register' route,
    // redirect to the home page
    next({ name: "home" });
  } else {
    // Allow navigation to other routes
    next();
  }
});
export default router;

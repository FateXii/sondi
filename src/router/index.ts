import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import Home from "../views/Home.vue";
import Admin from "../views/Admin.vue";
import LoginForm from "@/components/Admin/LoginForm.vue";
import RegistrationForm from "@/components/Admin/RegistrationForm.vue";
import AdminPanel from "@/components/Admin/AdminPanel.vue";

const routes: Array<RouteRecordRaw> = [
  {
    path: "/",
    name: "Home",
    component: Home,
  },
  {
    path: "/dashboard",
    name: "Admin",
    component: Admin,
    children: [
      {
        path: "",
        component: AdminPanel,
      },
      {
        path: "login",
        component: LoginForm,
      },

      {
        path: "register",
        component: RegistrationForm,
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;

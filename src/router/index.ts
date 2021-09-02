import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import Home from "../views/Home.vue";
import Admin from "../views/Admin.vue";
import LoginForm from "@/components/Admin/LoginForm.vue";
import RegistrationForm from "@/components/Admin/RegistrationForm.vue";
import AdminPanel from "@/components/Admin/AdminPanel.vue";
import NewProperty from "@/components/Properties/NewProperty.vue";

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
        path: "login",
        component: LoginForm,
      },

      {
        path: "register",
        component: RegistrationForm,
      },
      {
        path: "",
        component: AdminPanel,
        children: [
          {
            path: "new_property",
            component: NewProperty,
          },
        ],
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;

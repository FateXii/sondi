import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import Home from "../views/Home.vue";
import Admin from "../views/Admin.vue";
import LoginForm from "@/components/Admin/LoginForm.vue";
import RegistrationForm from "@/components/Admin/RegistrationForm.vue";
import AdminPanel from "@/components/Admin/AdminPanel.vue";
import NewProperty from "@/components/Properties/NewProperty.vue";
import PropertyList from "@/components/Properties/PropertyList.vue";
import PropertyDetails from "@/components/Properties/PropertyDetail.vue";
import UserList from "@/components/User/UserList.vue";
import NewUser from "@/components/User/NewUser.vue";
import NotFoundComponent from "@/components/NotFoundComponent.vue";

const routes: Array<RouteRecordRaw> = [
  {
    path: "/",
    name: "Home",
    component: Home,
  },
  {
    path: "/login",
    component: LoginForm,
  },

  {
    path: "/register",
    component: RegistrationForm,
  },
  {
    path: "/dashboard",
    name: "Admin",
    component: Admin,
    children: [
      {
        path: "",
        component: AdminPanel,
        children: [
          {
            path: "users",
            component: UserList,
            meta: {
              requiresAuth: true,
              requiresAdmin: true,
            },
          },
          {
            path: "users/:id",
            component: PropertyDetails,
            meta: {
              requiresAuth: true,
              requiresAdmin: true,
            },
          },
          {
            path: "new_user",
            component: NewProperty,
            meta: {
              requiresAuth: true,
              requiresAdmin: true,
            },
          },
          {
            path: "properties",
            component: PropertyList,
            meta: {
              requiresAuth: true,
              requiresAdmin: true,
            },
          },
          {
            path: "properties/:id",
            component: PropertyDetails,
            meta: {
              requiresAuth: true,
              requiresAdmin: true,
            },
          },
          {
            path: "new_property",
            component: NewProperty,
            meta: {
              requiresAuth: true,
              requiresAdmin: true,
            },
          },
          {
            path: "not_found",
            component: NotFoundComponent,
            name: "NotFound",
          },
        ],
      },
    ],
  },
  {
    path: "/:catchAll(.*)",
    component: NotFoundComponent,
    name: "NotFoundError",
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;

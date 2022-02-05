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
import UserDetails from "@/components/User/UserDetails.vue";
import NewUser from "@/components/User/NewUser.vue";
import NotFoundComponent from "@/components/NotFoundComponent.vue";
import Properties from "@/views/Properties.vue";

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
    path: "/properties",
    name: "Properties",
    component: Properties,
    children: [
      {
        path: "",
        component: PropertyList,
        props: true,
      },
      {
        path: ":id",
        component: PropertyDetails,
        props: true,
      },
    ],
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
          },
          {
            path: "users/:id",
            component: UserDetails,
            props: true,
          },
          {
            path: "new_user/:role",
            component: NewUser,
            props: true,
          },
          {
            path: "properties",
            component: PropertyList,
          },
          {
            path: "properties/:id",
            component: PropertyDetails,
            props: true,
          },
          {
            path: "new_property",
            component: NewProperty,
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
  scrollBehavior(to) {
    if (to.hash) {
      return {
        el: to.hash,
        behavior: "smooth",
      };
    }
  },
});

export default router;

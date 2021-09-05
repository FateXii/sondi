import axios, { AxiosInstance } from "axios";
import { IUserLoginData, IUserRegistrationData } from "@/interfaces/apiTypes";
import { isGuest, authManager } from "@/composables/authManager";

export const authClient = axios.create({
  baseURL: process.env.VUE_APP_API_HOST,
  withCredentials: true, // required to handle the CSRF token
});

/*
 * Add a response interceptor
 */
authClient.interceptors.response.use(
  (response) => {
    return response;
  },
  function (error) {
    if (
      error.response &&
      [401, 419].includes(error.response.status) &&
      authManager().user &&
      !isGuest()
    ) {
      authManager().logout();
    }
    return Promise.reject(error);
  }
);

export default {
  async login(payload: IUserLoginData) {
    await authClient.get("/sanctum/csrf-cookie");
    return authClient.post("/login", payload);
  },
  logout() {
    return authClient.post("/logout");
  },
  getAuthUser() {
    return authClient.get("/api/user");
  },
  async register(payload: IUserRegistrationData) {
    await authClient.get("/sanctum/csrf-cookie");
    return authClient.post("/register", payload);
  },
};

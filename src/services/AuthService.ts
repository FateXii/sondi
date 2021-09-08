import axios, { AxiosInstance } from "axios";
import { IUserLoginData, IUserRegistrationData } from "@/interfaces/apiTypes";
import Auth, { GetAuthenticatedUser } from "@/store/auth";
import { AuthManager } from "@/composables/AuthManager";

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
      [401, 419].includes(error.response.status) &&
      error.response &&
      Auth.state.user &&
      Auth.IsGuest()
    ) {
      AuthManager().logout();
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

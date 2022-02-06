import axios, { AxiosRequestConfig } from "axios";
import Cookies from "js-cookie";

export const axiosClient = axios.create({
  baseURL: process.env.VUE_APP_API_HOST,
  withCredentials: true,
  headers: {
    "content-type": "application/json",
    Accept: "application/json",
    "X-Requested-With": "XMLHttpRequest",
  },
});

export async function requestInterceptor(config: AxiosRequestConfig) {
  if (
    (config.method == "post" ||
      config.method == "put" ||
      config.method == "delete") &&
    !Cookies.get("XSRF-TOKEN")
  ) {
    await axiosClient.get("/sanctum/csrf-cookie");
  }
  return config;
}

import axios, { AxiosResponse } from "axios";
import Auth, { IUserDataType } from "@/store/auth";
import { AuthManager } from "@/composables/AuthManager";

export const requestClient = axios.create({
  baseURL: process.env.VUE_APP_API_HOST,
  withCredentials: true,
  headers: {
    "content-type": "application/json",
    Accept: "application/json",
    "X-Requested-With": "XMLHttpRequest",
  },
});

/*
 * Add a response interceptor
 */
requestClient.interceptors.response.use(
  (response) => {
    return response;
  },
  function (error) {
    if (
      [401, 419].includes(error.response.status) &&
      error.response &&
      Auth().user.value &&
      Auth().IsGuest()
    ) {
      AuthManager().logout();
    }
    return Promise.reject(error);
  }
);
interface IAPIResponse<T> {
  data: T;
}

type AxiosApiResponse<T> = AxiosResponse<IAPIResponse<T>>;

export default {
  getAll(): Promise<AxiosApiResponse<IUserDataType[]>> {
    return requestClient.get("/api/profiles");
  },
  get(id: number): Promise<AxiosApiResponse<IUserDataType>> {
    return requestClient.get(`/api/profiles/${id}`);
  },
  update(id: number, data: any) {
    return requestClient.put(`/api/profiles/${id}`, data);
  },
  delete(id: number) {
    return requestClient.delete(`/api/profiles/${id}`);
  },
  getPotential(): Promise<AxiosApiResponse<any[]>> {
    return requestClient.get("/api/profiles/new");
  },
  create(data: any) {
    return requestClient.post("/api/profiles/new", data);
  },
};

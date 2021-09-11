import axios from "axios";
import { AxiosApiResponse } from "@/interfaces/Requests";
import { IUserDataType } from "@/store/auth";
import { IProperty } from "@/interfaces/Property";

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
requestClient.interceptors.response.use((response) => {
  return response;
});

export default {
  getAll(): Promise<AxiosApiResponse<IProperty[]>> {
    return requestClient.get("/api/properties");
  },
  get(id: number): Promise<AxiosApiResponse<IProperty>> {
    return requestClient.get(`/api/properties/${id}`);
  },
  update(id: number, data: any) {
    return requestClient.put(`/api/properties/${id}`, data);
  },
  delete(id: number) {
    return requestClient.delete(`/api/properties/${id}`);
  },
};

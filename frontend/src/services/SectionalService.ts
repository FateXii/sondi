import axios from "axios";
import { AxiosApiResponse } from "@/Types/Requests";
import { IProperty } from "@/Types/Property";
import { ISectional } from "@/Types/Sectional";

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
  getAll(): Promise<AxiosApiResponse<ISectional[]>> {
    return requestClient.get("/api/sectionals");
  },
  create(data: { name: string; type: string }) {
    return requestClient.post("/api/sectionals", data);
  },
  delete(id: number) {
    return requestClient.delete(`/api/sectionals/${id}`);
  },
};

import axios from "axios";
import { AxiosApiResponse } from "@/Types/Requests";
import { IUserDataType } from "@/store/auth";
import { IAgent, IProperty, IPropertyFeature } from "@/Types/Property";

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
  create(data: any) {
    return requestClient.post("/api/properties", data);
  },
  delete(id: number) {
    return requestClient.delete(`/api/properties/${id}`);
  },
  getFeatures(): Promise<AxiosApiResponse<IPropertyFeature[]>> {
    return requestClient.get("api/property/features");
  },
  createFeature(feature: string) {
    return requestClient.post("api/property/features/new", {
      feature,
    });
  },
  getAgents(): Promise<AxiosApiResponse<IAgent[]>> {
    return requestClient.get("api/agents");
  },
};

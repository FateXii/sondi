import axios, { AxiosResponse } from "axios";
import { AxiosApiResponse } from "@/Types/Requests";
import { IMessage } from "@/Types/Message";
import { axiosClient as requestClient, requestInterceptor } from "./Helpers";

/*
 * Add a response interceptor
 */
requestClient.interceptors.request.use(requestInterceptor);

export default {
  getAll(): Promise<AxiosApiResponse<IMessage[]>> {
    return requestClient.get("/api/messages");
  },
  get(id: number): Promise<AxiosApiResponse<IMessage>> {
    return requestClient.get(`/api/messages/${id}`);
  },
  // update(id: number, data: any) {
  //   return requestClient.put(`/api/messages/${id}`, data);
  // },
  create(data: IMessage): Promise<AxiosResponse<{ id: number }>> {
    return requestClient.post("/api/messages", data);
  },
  delete(id: number) {
    return requestClient.delete(`/api/messages/${id}`);
  },
};

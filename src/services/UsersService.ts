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
// "data": [],
//     "links": {
//         "first": "http://localhost:8000/api/profiles?page=1",
//         "last": "http://localhost:8000/api/profiles?page=1",
//         "prev": null,
//         "next": null
//     },
//     "meta": {
//         "current_page": 1,
//         "from": 1,
//         "last_page": 1,
//         "links": [
//             {
//                 "url": null,
//                 "label": "&laquo; Previous",
//                 "active": false
//             },
//             {
//                 "url": "http://localhost:8000/api/profiles?page=1",
//                 "label": "1",
//                 "active": true
//             },
//             {
//                 "url": null,
//                 "label": "Next &raquo;",
//                 "active": false
//             }
//         ],
//         "path": "http://localhost:8000/api/profiles",
//         "per_page": 25,
//         "to": 11,
//         "total": 11

interface ILink {
  first: string;
  last: string;
  prev: string;
  next: string;
}
interface IAPIResponseMeta {
  current_page: number;
}
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
};

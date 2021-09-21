import { AxiosResponse } from "axios";

interface ILink {
  first: string;
  last: string;
  prev: string;
  next: string;
}
interface IAPIResponseMeta {
  current_page: number;
}
export interface IAPIResponse<T> {
  data: T;
}

export type AxiosApiResponse<T> = AxiosResponse<IAPIResponse<T>>;

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

import axios, { AxiosInstance } from "axios";

const client: AxiosInstance = axios.create({
  baseURL: "http://localhost:8000",
  headers: {
    "content-type": "application/json",
  },
});

export default client;

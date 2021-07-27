import axios, { AxiosInstance } from "axios";

const client: AxiosInstance = axios.create({
  baseURL: process.env.API,
  headers: {
    "content-type": "application/json",
  },
});

export default client;

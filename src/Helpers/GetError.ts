import axios, { AxiosError } from "axios";

export type RespnseError = Error | AxiosError;
export default function GetError(error: RespnseError) {
  const errorMessage = "API Error, please try again.";

  if (error.name === "Fetch User") {
    return error.message;
  }

  if (axios.isAxiosError(error)) {
    if (!error.response) {
      console.error(`API ${error.config.url} not found`);
      return errorMessage;
    }
    if (process.env.NODE_ENV === "development") {
      console.error(error.response.data);
      console.error(error.response.status);
      console.error(error.response.headers);
    }
    if (error.response.data && error.response.data.errors) {
      return error.response.data.errors;
    }
  }
  return errorMessage;
}

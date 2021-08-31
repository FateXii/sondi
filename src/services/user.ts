import http from "@/services/http-service";
import { IUserLoginData, IUserRegistrationData } from "@/interfaces/apiTypes";
import IAxiosResponse from "@/interfaces/schemas";

class User {
  register(data: IUserRegistrationData): Promise<any> {
    return http.post("/register", data);
  }

  async login(data: IUserLoginData): Promise<any> {
    await http.get("/sanctum/csrf-cookie");
    return http.post("/login", data);
  }

  logout(): Promise<any> {
    return http.post("/logout");
  }

  get(): Promise<IAxiosResponse<any>> {
    return http.get("/api/user");
  }
}

export default new User();

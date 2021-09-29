import http from "@/services/http-service";
import { IAddress } from "@/Types/apiTypes";

class Address {
  create(data: IAddress): Promise<any> {
    return http.post("/api/address", data);
  }

  update(addressId: number, data: IAddress): Promise<any> {
    return http.put(`/api/address/${addressId}`, data);
  }

  getAll(): Promise<any> {
    return http.get("/api/address");
  }

  delete(addressId: number): Promise<any> {
    return http.delete(`/api/address/${addressId}`);
  }

  get(addressId: number): Promise<any> {
    return http.get(`/api/address/${addressId}`);
  }
}

export default new Address();

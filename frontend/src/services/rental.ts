import http from "@/services/http-service";
import { IProperty, IRental } from "@/Types/apiTypes";

class Rental {
  create(data: IRental): Promise<any> {
    return http.post("/api/rentals", data);
  }
  update(rentalId: number, data: IRental): Promise<any> {
    return http.put(`/api/rentals/${rentalId}`, data);
  }

  getAll(): Promise<any> {
    return http.get("/api/rentals");
  }

  delete(rentalId: number): Promise<any> {
    return http.delete(`/api/rentals/${rentalId}`);
  }
  get(rentalId: number): Promise<any> {
    return http.get(`/api/rentals/${rentalId}`);
  }
}

export default new Rental();

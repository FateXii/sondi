import http from "@/services/http-service";
import { IProperty, ISale } from "@/interfaces/apiTypes";

class Sale {
  create(data: ISale): Promise<any> {
    return http.post("/api/sales", data);
  }
  update(saleId: number, data: ISale): Promise<any> {
    return http.put(`/api/sales/${saleId}`, data);
  }

  getAll(): Promise<any> {
    return http.get("/api/sales");
  }

  delete(saleId: number): Promise<any> {
    return http.delete(`/api/sales/${saleId}`);
  }
  get(saleId: number): Promise<any> {
    return http.get(`/api/sales/${saleId}`);
  }
}

export default new Sale();

import http from "@/services/http-service";
import { IProperty } from "@/interfaces/apiTypes";

class Property {
  create(data: IProperty): Promise<any> {
    return http.post("/api/properties", data);
  }
  update(propertyId: number, data: IProperty): Promise<any> {
    return http.put(`/api/properties/${propertyId}`, data);
  }

  getAll(): Promise<any> {
    return http.get("/api/properties");
  }

  delete(propertyId: number): Promise<any> {
    return http.delete(`/api/properties/${propertyId}`);
  }

  get(propertyId: number): Promise<any> {
    return http.get(`/api/properties/${propertyId}`);
  }
}

export default new Property();

import http from "@/services/http-service";

interface SaleType {
  property_id?: number;
  price?: number;
}
interface PropertyType {
  bathrooms?: number;
  bedrooms?: number;
  garages?: number;
  sectional_unit_id?: number;
  stand_alines_id?: number;
  description?: string;
}

interface ResponseSaleType {
  id: number;
  property?: PropertyType;
  price?: number;
}

class Sale {
  create(data: SaleType): Promise<ResponseSaleType> {
    return http.post("/api/address", data);
  }
  update(saleId: number, data: SaleType): Promise<ResponseSaleType> {
    return http.put(`/api/address/${saleId}`, data);
  }

  getAll(): Promise<ResponseSaleType> {
    return http.get("/api/address");
  }

  delete(saleId: number): Promise<ResponseSaleType> {
    return http.delete(`/api/address/${saleId}`);
  }
  get(saleId: number): Promise<ResponseSaleType> {
    return http.get(`/api/address/${saleId}`);
  }
}

export default new Sale();

import http from "@/services/http-service";

interface PropertyType {
  bathrooms?: number;
  bedrooms?: number;
  garages?: number;
  sectional_unit_id?: number;
  stand_alines_id?: number;
  description?: string;
}

interface ResponsePropertyType {
  id: number;
  bathrooms: number;
  bedrooms: number;
  garages: number;
  sectional_unit_id: number;
  stand_alines_id: number;
  description: string;
}

class Property {
  create(data: PropertyType): Promise<ResponsePropertyType> {
    return http.post("/api/properties", data);
  }
  update(
    propertyId: number,
    data: PropertyType
  ): Promise<ResponsePropertyType> {
    return http.put(`/api/properties/${propertyId}`, data);
  }

  getAll(): Promise<ResponsePropertyType> {
    return http.get("/api/properties");
  }

  delete(propertyId: number): Promise<ResponsePropertyType> {
    return http.delete(`/api/properties/${propertyId}`);
  }
  get(propertyId: number): Promise<ResponsePropertyType> {
    return http.get(`/api/properties/${propertyId}`);
  }
}

export default new Property();

import http from "@/services/http-service";
import { IPropertyImage } from "@/interfaces/apiTypes";

class Property {
  create(property_id: number, data: FormData): Promise<any> {
    return http.post(`/api/properties/${property_id}/images`, data, {
      headers: {
        "content-type": "multipart/form-data",
      },
    });
  }
  update(imageId: number, data: IPropertyImage): Promise<any> {
    return http.put(`/api/images/${imageId}`, data);
  }

  delete(imageId: number): Promise<any> {
    return http.delete(`/api/images/${imageId}`);
  }

  getAll(propertyId: number): Promise<any> {
    return http.get(`/api/properties/${propertyId}/images`);
  }
}

export default new Property();

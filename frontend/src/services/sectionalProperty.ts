import http from "@/services/http-service";
import {
  ISectionalProperty,
  ISectionalPropertyModel,
} from "@/interfaces/apiTypes";
import IAxiosResponse from "@/interfaces/schemas";

class SectionalProperty {
  create(data: FormData): Promise<IAxiosResponse<ISectionalPropertyModel>> {
    return http.post("/api/sectionals", data, {
      headers: {
        "content-type": "multipart/form-data",
      },
    });
  }
  update(
    sectionalPropertyId: number,
    data: ISectionalProperty
  ): Promise<IAxiosResponse<ISectionalPropertyModel>> {
    return http.put(`/api/sectionals/${sectionalPropertyId}`, data);
  }

  getAll(): Promise<IAxiosResponse<ISectionalPropertyModel[]>> {
    return http.get("/api/sectionals");
  }

  getAllUnits(
    sectionalPropertyId: number
  ): Promise<IAxiosResponse<ISectionalPropertyModel>> {
    return http.get(`/api/sectionals/${sectionalPropertyId}/unit`);
  }

  delete(
    sectionalPropertyId: number
  ): Promise<IAxiosResponse<ISectionalPropertyModel>> {
    return http.delete(`/api/sectionals/${sectionalPropertyId}`);
  }
  get(
    sectionalPropertyId: number
  ): Promise<IAxiosResponse<ISectionalPropertyModel>> {
    return http.get(`/api/sectionals/${sectionalPropertyId}`);
  }
}

export default new SectionalProperty();

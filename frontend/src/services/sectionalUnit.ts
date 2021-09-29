import http from "@/services/http-service";
import { ISectionalUnit, ISectionalUnitModel } from "@/Types/apiTypes";
import IAxiosResponse from "@/Types/schemas";

class SectionalUnit {
  create(
    sectionalPropertyId: number,
    data: ISectionalUnit
  ): Promise<IAxiosResponse<ISectionalUnitModel>> {
    return http.post(`/api/sectionals/${sectionalPropertyId}/unit`, data);
  }

  update(
    sectionalUnitId: number,
    data: ISectionalUnit
  ): Promise<IAxiosResponse<ISectionalUnitModel>> {
    return http.put(`/api/unit/${sectionalUnitId}`, data);
  }

  delete(
    sectionalUnitId: number
  ): Promise<IAxiosResponse<ISectionalUnitModel>> {
    return http.delete(`/api/unit/${sectionalUnitId}`);
  }
  get(
    sectionalUnitId: number,
    sectionalPropertyId: number
  ): Promise<IAxiosResponse<ISectionalUnitModel>> {
    return http.get(
      `/api/sectionals/${sectionalPropertyId}/unit/${sectionalUnitId}`
    );
  }
}

export default new SectionalUnit();

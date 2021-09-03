import http from "@/services/http-service";
import {
  IStandAloneProperty,
  IStandAlonePropertyModel,
} from "@/interfaces/apiTypes";
import IAxiosResponse from "@/interfaces/schemas";

class StandAloneProperty {
  create(
    data: IStandAloneProperty
  ): Promise<IAxiosResponse<IStandAlonePropertyModel>> {
    return http.post("/api/stand_alone", data);
  }

  getAll(): Promise<IAxiosResponse<IStandAlonePropertyModel[]>> {
    return http.get("/api/stand_alone");
  }

  delete(
    sectionalPropertyId: number
  ): Promise<IAxiosResponse<IStandAlonePropertyModel>> {
    return http.delete(`/api/stand_alone/${sectionalPropertyId}`);
  }

  get(
    sectionalPropertyId: number
  ): Promise<IAxiosResponse<IStandAlonePropertyModel>> {
    return http.get(`/api/stand_alone/${sectionalPropertyId}`);
  }
}

export default new StandAloneProperty();

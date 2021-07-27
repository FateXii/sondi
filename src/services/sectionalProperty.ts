import http from "@/services/http-service";

interface SectionalPropertyData {
  name: string;
  type: string;
  addresses_id: number;
}

class SectionalProperty {
  create(data: SectionalPropertyData): Promise<any> {
    return http.post("/api/sectionals", data);
  }
  update(
    sectionalPropertyId: number,
    data: SectionalPropertyData
  ): Promise<any> {
    return http.put(`/api/sectionals/${sectionalPropertyId}`, data);
  }

  getAll(): Promise<any> {
    return http.get("/api/sectionals");
  }

  getAllUnits(sectionalPropertyId: number): Promise<any> {
    return http.get(`/api/sectionals/${sectionalPropertyId}/unit`);
  }

  delete(sectionalPropertyId: number) {
    return http.delete(`/api/sectionals/${sectionalPropertyId}`);
  }
  get(sectionalPropertyId: number) {
    return http.get(`/api/sectionals/${sectionalPropertyId}`);
  }
}

export default new SectionalProperty();

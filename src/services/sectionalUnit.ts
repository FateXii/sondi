import http from "@/services/http-service";

interface SectionalUnitData {
  unit: string;
}

class SectionalUnit {
  create(data: SectionalUnitData): Promise<any> {
    return http.post("/api/sectionals/${sectionalPropertyId}/unit", data);
  }

  update(sectionalUnitId: number, data: SectionalUnitData): Promise<any> {
    return http.put(`/api/unit/${sectionalUnitId}`, data);
  }

  delete(sectionalUnitId: number): Promise<any> {
    return http.delete(`/api/unit/${sectionalPropertyId}`);
  }
  get(sectionalUnitId: number, sectionalPropertyId: number): Promise<any> {
    return http.get(
      `/api/sectionals/${sectionalPropertyId}/unit/${sectionalUnitId}`
    );
  }
}

export default new SectionalUnit();

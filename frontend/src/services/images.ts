import http from "@/services/http-service";
import { IImage } from "@/Types/apiTypes";

class Image {
  create(data: IImage): Promise<any> {
    return http.post("/api/images", data);
  }

  update(imagesId: number, data: IImage): Promise<any> {
    return http.put(
      `/api/images/${imagesId}`,
      {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      },
      data
    );
  }

  getAll(): Promise<any> {
    return http.get("/api/images");
  }

  delete(imagesId: number): Promise<any> {
    return http.delete(`/api/images/${imagesId}`);
  }

  get(imagesId: number): Promise<any> {
    return http.get(`/api/images/${imagesId}`);
  }
}

export default new Image();

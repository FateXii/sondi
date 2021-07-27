import http from "@/services/http-service";

declare type Province =
  | "limpopo"
  | "mpumalanga"
  | "western cape"
  | "eastern cape"
  | "northern cape"
  | "kwazulu natal"
  | "gauteng"
  | "free state"
  | "north west";

interface AddressData {
  street?: string;
  city?: string;
  province?: Province;
  postal_code?: string;
}

interface ResponseAddressType {
  id: number;
  street: string;
  city: string;
  province: Province;
  postal_code: string;
}

class Address {
  create(data: AddressData): Promise<ResponseAddressType> {
    return http.post("/api/address", data);
  }
  update(addressId: number, data: AddressData): Promise<ResponseAddressType> {
    return http.put(`/api/address/${addressId}`, data);
  }

  getAll(): Promise<ResponseAddressType> {
    return http.get("/api/address");
  }

  delete(addressId: number): Promise<ResponseAddressType> {
    return http.delete(`/api/address/${addressId}`);
  }
  get(addressId: number): Promise<ResponseAddressType> {
    return http.get(`/api/address/${addressId}`);
  }
}

export default new Address();

export class IAddress {
  id?: number;
  street: string;
  city: string;
  province: string;
  postal_code: string;
  constructor() {
    this.street = "";
    this.city = "";
    this.province = "";
    this.postal_code = "";
  }
}

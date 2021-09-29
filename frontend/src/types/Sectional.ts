import { IAddress } from "@/Types/Address";

export interface ISectional {
  id: number;
  name: string;
  type: string;
  address: IAddress;
}

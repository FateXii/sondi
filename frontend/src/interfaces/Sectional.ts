import { IAddress } from "@/interfaces/Address";

export interface ISectional {
  id: number;
  name: string;
  type: string;
  address: IAddress;
}

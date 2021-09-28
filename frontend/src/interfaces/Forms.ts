import { IPropertyAddress } from "./Property";
import { IAddress } from "./Address";

export interface IAddressForm {
  isSectional: boolean;
  sectionalId: number;
  address: IAddress & IPropertyAddress;
}

export interface IPropertyDescriptionForm {
  title: string;
  price: number;
  address: {
    isSectional: boolean;
    sectionalId: number;
    address: {
      unit: string;
      street: string;
      city: string;
      province: string;
      postal_code: string;
    };
  };
  description: {
    text: string;
    heading: string;
  };
}

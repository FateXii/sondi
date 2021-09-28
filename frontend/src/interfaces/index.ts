import { IAddress } from "./Address";
import { ElFile } from "./element-plus.d";
import { IPropertyAddress } from "./Property";

type Optional<T> = T | undefined;
interface List<T> {
  list: T[];
}

interface IAddressForm {
  isSectional: boolean;
  sectionalId: number;
  address: IAddress & IPropertyAddress;
}
export { Optional, ElFile, List, IAddressForm };

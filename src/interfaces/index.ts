import { IRentalModel, ISaleModel } from "./apiTypes";
import { ElFile } from "./element-plus.d";

interface PropertyImage {
  coverImage: string;
  allImages: Array<string>;
}

type Property = ISaleModel | IRentalModel;

interface State {
  list: Property[];
  properties: Property[];
  viewing: number;
  buying: boolean;
  interested: number[];
  authenticated: boolean;
}

export { Property, State, PropertyImage, ElFile };

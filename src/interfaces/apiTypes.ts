interface IModel {
  id: number;
}

export interface ISectionalUnit {
  sectionals_id: number;
  unit: string;
}

export interface IImage {
  path: File;
}

export interface ISectionalProperty {
  name: string;
  type: string;
  image: File;
  addresses_id: number;
}

export interface IProperty {
  bathrooms: number;
  bedrooms: number;
  garages: number;
  sectional_units_id?: number;
  stand_alones_id?: number;
  description: string;
}

export interface IPropertyImage {
  property_id: number;
  image_id: number;
}

export interface ISale {
  property_id: number;
  price: number;
}

export interface IRental {
  property_id: number;
  price: number;
}

export interface IAddress {
  street: string;
  city: string;
  province: Province;
  postal_code: string;
}
export interface IPropertyImageModel extends IPropertyImage, IModel {}
export interface IAddressModel extends IAddress, IModel {}

export interface ISectionalUnitModel extends ISectionalUnit, IModel {}

export interface IImageModel extends IImage, IModel {}

export interface ISectionalPropertyModel extends ISectionalProperty, IModel {}

export interface IPropertyModel extends IProperty, IModel {}

export interface ISaleModel extends ISale, IModel {
  property: IPropertyModel;
}
export interface IRentalModel extends IRental, IModel {
  property: IPropertyModel;
}

export type Province =
  | "limpopo"
  | "mpumalanga"
  | "western cape"
  | "eastern cape"
  | "northern cape"
  | "kwazulu natal"
  | "gauteng"
  | "free state"
  | "north west";

interface IModel {
  id: number;
}
interface IUser {
  id: number;
  name: string;
  email: string;
  is_admin: boolean;
  is_agent: boolean;
  is_tenant: boolean;
}

interface ISectionalUnit {
  sectionals_id: number;
  unit: string;
}

interface IImage {
  path: File;
}

interface IStandAloneProperty {
  addresses_id: number;
}
interface ISectionalProperty {
  name: string;
  type: string;
  image: File;
  addresses_id: number;
}

//  interface IProperty {
//   bathrooms: number;
//   bedrooms: number;
//   garages: number;
//   sectional_units_id?: number;
//   stand_alones_id?: number;
//   description: string;
// }

interface IPropertyImage {
  property_id: number;
  image_id: number;
}

interface ISale {
  property_id: number;
  price: number;
}

interface IRental {
  property_id: number;
  price: number;
}

interface IUserLoginData {
  email: string;
  password: string;
}
interface IUserRegistrationData {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
}
interface IAddress {
  street: string;
  city: string;
  province: Province;
  postal_code: string;
}
interface IPropertyImageModel extends IPropertyImage, IModel {}
interface IAddressModel extends IAddress, IModel {}

interface ISectionalUnitModel extends ISectionalUnit, IModel {}

interface IImageModel extends IImage, IModel {}

interface ISectionalPropertyModel extends ISectionalProperty, IModel {}

//  interface IPropertyModel extends IProperty, IModel {}

interface IStandAlonePropertyModel extends IStandAloneProperty, IModel {}

type Province =
  | "limpopo"
  | "mpumalanga"
  | "western cape"
  | "eastern cape"
  | "northern cape"
  | "kwazulu natal"
  | "gauteng"
  | "free state"
  | "north west";

export interface IProperty {
  id: number;
  description: string;
  description_title: string;
  video_url: string;
  cover_image: string;
  title: string;
  features: string;
  is_rental: number;
  price: number;
  images: IImage[];
  address: IPropertyAddress;
  is_sectional: boolean;
  agents: IAgent[];
}

interface IAgent {
  id: number;
  name: string;
  phone_number: string;
  image: string;
  email: string;
}

export interface IPropertyAddress extends IAddress {
  unit?: string;
}

interface IImage {
  id: number;
  path: string;
}

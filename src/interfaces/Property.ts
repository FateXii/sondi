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
  address: IAddress;
  is_sectional: boolean;
}

interface IAddress {
  id: number;
  street: string;
  city: string;
  province: string;
  postal_code: string;
  unit?: string;
}

interface IImage {
  id: number;
  path: string;
}

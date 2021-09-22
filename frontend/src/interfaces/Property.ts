import { IAddress } from "@/interfaces/Address";

export interface IProperty {
  id: number;
  description: string;
  description_title: string;
  video_url: string;
  cover_image: string;
  title: string;
  features: IPropertyFeature[];
  is_rental: number;
  price: number;
  images: IImage[];
  address: IPropertyAddress;
  is_sectional: boolean;
  agents: IAgent[];
}

export interface IPropertyFeature {
  id: number;
  value?: string;
  type: string;
  name: string;
}

export interface ICurrentFeature {
  id: number;
  value: string;
  type: string;
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

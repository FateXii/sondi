import { ref, Ref } from "vue";
import addressApi from "@/services/Addresses";
import sectionalApi from "@/services/sectionalProperty";
import {
  IAddressModel,
  ISectionalPropertyModel,
  Province,
} from "@/Types/apiTypes";
import AxiosResponse from "@/Types/schemas";

const PROVINCE_LIST: Province[] = [
  "limpopo",
  "mpumalanga",
  "western cape",
  "eastern cape",
  "northern cape",
  "kwazulu natal",
  "gauteng",
  "free state",
  "north west",
];

export interface ISectionalPropertyForm {
  type: string;
  name: string;
  image?: File;
  address: {
    street: string;
    city: string;
    province: Province;
    postal_code: string;
  };
}

const createdSectionalProperty = ref<ISectionalPropertyModel | undefined>();

interface INewSectionalProperty {
  createdSectionalProperty: Ref<ISectionalPropertyModel | undefined>;
  createSectionalProperty: (arg: ISectionalPropertyForm) => void;
  PROVINCE_LIST: Province[];
}

export const newSectionalProperty = (): INewSectionalProperty => {
  const createSectionalProperty = (
    inputFormData: ISectionalPropertyForm
  ): void => {
    const { name, type, image, address } = inputFormData;
    addressApi
      .create(address)
      .then((response: AxiosResponse<IAddressModel>) => {
        const { data } = response;
        const address_id = data.id;
        const formData = new FormData();
        formData.append("addresses_id", String(address_id));
        formData.append("name", name);
        formData.append("type", type);
        if (image) {
          formData.append("image", image);
        }
        sectionalApi
          .create(formData)
          .then((response: AxiosResponse<ISectionalPropertyModel>) => {
            const { data } = response;
            createdSectionalProperty.value = data;
          })
          .catch((e) => console.log(e));
      })
      .catch((e) => console.log(e));
  };

  return {
    createdSectionalProperty,
    createSectionalProperty,
    PROVINCE_LIST,
  };
};

import { ElFile } from "@/interfaces";
import { ElUpload } from "element-plus/lib/el-upload/src/upload.type";
import { reactive, ref, watch, watchEffect } from "vue";
import propertyApi from "@/services/property";
import { AxiosResponse } from "axios";
import { useRouter } from "vue-router";

export enum PropertyType {
  Sectional,
  StandAlone,
}
export enum SectionalType {
  Apartment = "apartment",
  Complex = "complex",
}
export const DATA = {
  provinces: [
    "Limpopo",
    "Mpumalanga",
    "Western Cape",
    "Eastern Cape",
    "Northern Cape",
    "Kwazulu Natal",
    "Gauteng",
    "Free State",
    "North West",
  ],
  sectionalTypes: [
    { value: SectionalType.Apartment, label: "Apartment/Flat" },
    { value: SectionalType.Complex, label: "Complex/Estate" },
  ],
  propertyTypes: [
    {
      label: "Sectional",
      value: PropertyType.Sectional,
    },
    {
      label: "Stand Alone",
      value: PropertyType.StandAlone,
    },
  ],
};

enum Bool {
  false = "0",
  true = "1",
}
interface IPropertyForm {
  type: PropertyType;
  //if type is Sectional
  sectionalType: SectionalType;
  unit: string;
  //description
  sale: Bool;
  price: number;
  description: string;
  video_url: string;
  cover_image: ElFile | undefined;

  //address
  title: string;
  name: string;
  street: string;
  city: string;
  province: string;
  postal_code: string;
  //features
  bedrooms: number;
  size: number;
  bathrooms: number;
  garages: number;
  plot_size: number;

  images: ElFile[];
}

function createFormData(property: IPropertyForm, isSectional: Bool): FormData {
  const propertyFormData = new FormData();
  propertyFormData.append("isSectional", isSectional);
  propertyFormData.append("type", property.sectionalType);
  propertyFormData.append("unit", property.unit);
  propertyFormData.append("title", property.title);
  propertyFormData.append("name", property.name);

  propertyFormData.append("bedrooms", property.bedrooms.toString());
  propertyFormData.append("bathrooms", property.bathrooms.toString());
  propertyFormData.append("garages", property.garages.toString());
  propertyFormData.append("video_url", property.video_url);

  propertyFormData.append("description", property.description);
  propertyFormData.append("sale", property.sale);
  propertyFormData.append("price", property.price.toString());

  propertyFormData.append("street", property.street);
  propertyFormData.append("province", property.province);
  propertyFormData.append("postal_code", property.postal_code);
  propertyFormData.append("city", property.city);

  if (property.cover_image) {
    propertyFormData.append("cover_image", property.cover_image);
  }
  for (let index = 0; index < property.images.length; index++) {
    console.warn(index);
    propertyFormData.append("images[]", property.images[index]);
  }
  return propertyFormData;
}

export const manageNewProperty = (): any => {
  const uploadedImages = ref<ElUpload>();
  const uploadedCoverImage = ref<ElUpload>();
  const property = reactive<IPropertyForm>({
    type: PropertyType.StandAlone,
    //if type is Sectional
    sectionalType: SectionalType.Apartment,
    unit: "",
    //description
    sale: Bool.true,
    price: 1,
    description: "",
    video_url: "Youtube video link",
    cover_image: undefined,

    //address
    title: "name",
    name: "name",
    street: "",
    city: "",
    province: "",
    postal_code: "",
    //features
    bedrooms: 0,
    size: 0,
    bathrooms: 0,
    garages: 0,
    plot_size: 0,

    images: [],
  });
  const isSectional = ref<Bool>(Bool.false);
  watchEffect(() => {
    if (uploadedImages.value) {
      for (
        let index = 0;
        index < uploadedImages.value.uploadFiles.length;
        index++
      ) {
        property.images.push(uploadedImages.value.uploadFiles[index].raw);
      }
    }
  });
  watchEffect(() => {
    if (uploadedCoverImage.value) {
      property.cover_image = uploadedCoverImage.value.uploadFiles[0]?.raw;
    }
  });
  watch(property, (property: IPropertyForm) => {
    isSectional.value =
      property.type === PropertyType.Sectional ? Bool.true : Bool.false;
  });
  const creatingProperty = ref(false);
  const router = useRouter();
  function onSubmit() {
    creatingProperty.value = true;
    const propertyFormData = createFormData(property, isSectional.value);
    propertyApi
      .completeCreate(propertyFormData)
      .then((response: AxiosResponse) => {
        if (response.status == 201) {
          const { data } = response;
          creatingProperty.value = false;
          router.push(`/dashboard/properties/${data.id}`);
        }
      })
      .catch((e) => {
        creatingProperty.value = false;
        console.error(e);
      });
  }
  return {
    uploadedCoverImage,
    uploadedImages,
    property,
    isSectional,
    onSubmit,
  };
};

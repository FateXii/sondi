import { ElFile } from "@/interfaces";
import { reactive, ref, watch, watchEffect } from "vue";
import PropertyService from "@/services/PropertyService";
import { AxiosResponse } from "axios";
import { useRouter } from "vue-router";
import { ElUpload } from "element-plus";

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

interface IFeatures {
  feature_id: number;
  value: string;
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

  images: ElFile[];
  features: IFeatures[];
}

function createFormData(property: IPropertyForm, isSectional: Bool): FormData {
  const propertyFormData = new FormData();
  propertyFormData.append("isSectional", isSectional);
  propertyFormData.append("type", property.sectionalType);
  propertyFormData.append("unit", property.unit);
  propertyFormData.append("title", property.title);
  propertyFormData.append("name", property.name);

  propertyFormData.append("features", JSON.stringify(property.features));
  propertyFormData.append("video_url", property.video_url);

  propertyFormData.append("description", property.description);
  propertyFormData.append("is_rental", property.sale);
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

export const NewProperty = (): any => {
  const uploadedImages = ref<typeof ElUpload>();
  const uploadedCoverImage = ref<typeof ElUpload>();
  const newFeature = ref("");
  const property = reactive<IPropertyForm>({
    type: PropertyType.StandAlone,
    //if type is Sectional
    sectionalType: SectionalType.Apartment,
    unit: "",
    //description
    sale: Bool.false,
    price: 1,
    description: "",
    video_url: "",
    cover_image: undefined,

    //address
    title: "",
    name: "",
    street: "",
    city: "",
    province: "",
    postal_code: "",

    images: [],
    features: [
      {
        feature_id: Number(),
        value: "",
      },
    ],
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
  function addFeature() {
    property.features.push({
      feature_id: Number(),
      value: "yes",
    });
  }
  function removeFeature() {
    property.features.pop();
  }
  function onSubmit() {
    creatingProperty.value = true;
    const propertyFormData = createFormData(property, isSectional.value);
    PropertyService.create(propertyFormData)
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
    addFeature,
    onSubmit,
    removeFeature,
    newFeature,
  };
};

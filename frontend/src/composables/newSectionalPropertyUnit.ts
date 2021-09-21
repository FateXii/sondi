import { reactive, Ref, ref } from "vue";
import propertyApi from "@/services/property";
import sectionalUnitApi from "@/services/sectionalUnit";
import propertyImage from "@/services/PropertyImage";
import salesApi from "@/services/sale";
import rentalsApi from "@/services/rental";
import IAxiosResponse from "@/interfaces/schemas";
import {
  IProperty,
  IPropertyModel,
  ISectionalPropertyModel,
  ISectionalUnitModel,
} from "@/interfaces/apiTypes";
import { newSectionalProperty } from "@/composables/newSectionalProperty";

const sectionalUnit = ref("");
const isForSale = ref(false);
const price = ref(0.0);
const images = ref<FileList>();
const propertyForm = reactive<IProperty>({
  bedrooms: 0,
  garages: 0,
  bathrooms: 0,
  description: "",
});

export const newSectionalPropertyUnit = () => {
  const { createdSectionalProperty } = newSectionalProperty();
  const createSectionalPropertyUnit = (
    sectionalProperty:
      | ISectionalPropertyModel
      | undefined = createdSectionalProperty.value
  ) => {
    if (sectionalProperty) {
      const sectionals_id = sectionalProperty.id;
      //Create Sectional Unit for a sectional Property
      sectionalUnitApi
        .create(sectionals_id, {
          unit: sectionalUnit.value,
          sectionals_id,
        })
        .then((response: IAxiosResponse<ISectionalUnitModel>) => {
          const { data } = response;
          // Create a property for the sectional unit
          propertyApi
            .create({
              sectional_units_id: data.id,
              ...propertyForm,
            })
            .then((response: IAxiosResponse<IPropertyModel>) => {
              const { data } = response;
              const property_id = data.id;
              //create multiple images for the properties
              const formData = new FormData();
              const imageList = images.value;
              if (imageList) {
                for (let i = 0; i < imageList.length; i++) {
                  console.log(imageList[i]);
                  formData.append("images[]", imageList[i]);
                }
              }
              propertyImage
                .create(property_id, formData)
                .then((response) => {
                  const { data } = response;
                  console.log(data);
                })
                .catch((error) => console.log(error));
              if (isForSale.value) {
                //if its a property for sale create a sale property
                salesApi
                  .create({
                    price: price.value,
                    property_id,
                  })
                  .then((response) => {
                    const { data } = response;
                    console.log(data);
                  })
                  .catch((error) => console.log(error));
              } else {
                //if its a rental property create rental property
                rentalsApi
                  .create({
                    price: price.value,
                    property_id,
                  })
                  .then((response) => {
                    const { data } = response;
                    console.log(data);
                  })
                  .catch((error) => console.log(error));
              }
            })
            .catch((error) => console.log(error));
        })
        .catch((error) => console.log(error));
    }
  };
  const setPropertyImages = (e: any): void => {
    images.value = e.target.files;
  };
  return {
    createSectionalPropertyUnit,
    isForSale,
    price,
    setPropertyImages,
    propertyForm,
    sectionalUnit,
  };
};

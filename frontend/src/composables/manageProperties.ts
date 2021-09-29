import { IRentalModel, ISaleModel } from "@/Types/apiTypes";
import { ref } from "vue";
import saleApi from "@/services/sale";
import rentApi from "@/services/rental";
import { Property } from "@/Types";

const propertiesForSale = ref<ISaleModel[]>([]);
const propertiesForRent = ref<IRentalModel[]>([]);
const currentlyViewing = ref<Property>();
const isBuying = ref(false);

export const manageProperties = () => {
  const setPropertiesForSale = () => {
    saleApi.getAll().then((response) => {
      const { data } = response;
      propertiesForSale.value = data;
    });
  };
  const setPropertiesForRent = () => {
    rentApi.getAll().then((response) => {
      const { data } = response;
      propertiesForRent.value = data;
    });
  };
  const setCurrentlyViewing = (property: Property): void => {
    currentlyViewing.value = property;
  };

  return {
    setPropertiesForRent,
    propertiesForRent,
    setPropertiesForSale,
    propertiesForSale,
    currentlyViewing,
    setCurrentlyViewing,
    isBuying,
  };
};

import { Ref, ref } from "vue";

import { Property } from "@/interfaces";

type OptionalProperty = Property | undefined;

interface IPropertyModalManager {
  propertyModal: Ref<boolean>;
  openPropertyModal: () => void;
  closePropertyModal: () => void;
  makeProperty: (input: Ref<OptionalProperty>) => Property;
}

const propertyModal = ref(false);

const managePropertyModal = (): IPropertyModalManager => {
  const openPropertyModal = (): void => {
    propertyModal.value = true;
  };

  const closePropertyModal = (): void => {
    propertyModal.value = false;
  };

  const makeProperty = (input: Ref<OptionalProperty>): Property => {
    let property = {};
    if (input.value) {
      property = input.value;
    } else {
      property = {
        id: Number(),
        location: "",
        description: "",
        beds: Number(),
        baths: Number(),
        garages: Number(),
        buying: Boolean(),
        imageList: {
          coverImage: "",
          allImages: Array<string>(),
        },
        price: Number(),
        name: "",
        interested: Boolean(),
      };
    }
    return JSON.parse(JSON.stringify(property));
  };
  return {
    propertyModal,
    openPropertyModal,
    closePropertyModal,
    makeProperty,
  };
};
export default managePropertyModal;

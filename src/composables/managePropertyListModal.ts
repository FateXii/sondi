import { Ref, ref } from "vue";

interface IPropertyListModalManager {
  propertyListModal: Ref<boolean>;
  openPropertyListModal: () => void;
  closePropertyListModal: () => void;
}

const propertyListModal = ref(false);

export const managePropertyListModal = (): IPropertyListModalManager => {
  const openPropertyListModal = (): void => {
    propertyListModal.value = true;
    console.log(propertyListModal.value);
  };
  const closePropertyListModal = (): void => {
    propertyListModal.value = false;
  };
  return {
    openPropertyListModal,
    closePropertyListModal,
    propertyListModal,
  };
};

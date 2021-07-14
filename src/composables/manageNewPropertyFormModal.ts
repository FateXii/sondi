import { Ref, ref } from "vue";

interface INewPropertyFormModalManager {
  newPropertyFormModal: Ref<boolean>;
  openNewPropertyFormModal: () => void;
  closeNewPropertyFormModal: () => void;
}

const newPropertyFormModal = ref(false);

export const manageNewPropertyFormModal = (): INewPropertyFormModalManager => {
  const openNewPropertyFormModal = (): void => {
    newPropertyFormModal.value = true;
    console.log(newPropertyFormModal.value);
  };
  const closeNewPropertyFormModal = (): void => {
    newPropertyFormModal.value = false;
  };
  return {
    openNewPropertyFormModal,
    closeNewPropertyFormModal,
    newPropertyFormModal,
  };
};

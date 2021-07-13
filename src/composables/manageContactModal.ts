import { Ref, ref, reactive, watch } from "vue";

interface IContactInfo {
  name: string;
  email: string;
  message: string;
  number: string;
}
interface IContactModalManager {
  interested: Ref<boolean>;
  dialog: Ref<boolean>;
  formInfo: IContactInfo;
  openContactModal: () => void;
  closeContactModal: () => void;
}

const dialog = ref(false);
const interested = ref(false);
const formInfo = reactive({
  name: "",
  email: "",
  message: "",
  number: "",
});

export const manageContactModal = (): IContactModalManager => {
  const openContactModal = (): void => {
    dialog.value = true;
  };
  const closeContactModal = (): void => {
    dialog.value = false;
  };
  watch(dialog, (isClosed) => {
    if (isClosed) {
      openContactModal();
    } else {
      closeContactModal();
    }
  });
  return {
    dialog,
    interested,
    formInfo,
    openContactModal,
    closeContactModal,
  };
};

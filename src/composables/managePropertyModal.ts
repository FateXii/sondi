import { useStore } from "vuex";
import { computed, ComputedRef } from "vue";
import {
  CLOSE_PROPERTY_MODAL,
  OPEN_PROPERTY_MODAL,
} from "@/store/mutation-types";

interface IPropertyModalManager {
  propertyModal: ComputedRef<boolean>;
  openPropertyModal: () => void;
  closePropertyModal: () => void;
}
const managePropertyModal = (): IPropertyModalManager => {
  const store = useStore();
  const propertyModal = computed((): boolean => store.state.propertyModal);
  const openPropertyModal = (): void => store.commit(OPEN_PROPERTY_MODAL);
  const closePropertyModal = (): void => store.commit(CLOSE_PROPERTY_MODAL);
  return {
    propertyModal,
    openPropertyModal,
    closePropertyModal,
  };
};
export default managePropertyModal;

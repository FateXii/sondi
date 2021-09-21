import { ref } from "vue";
declare type FormStatus =
  | "sectional"
  | "sectionalDetails"
  | "sectionalUnit"
  | "existingSectionalNewUnit"
  | "standAlone"
  | "standAloneDetails";
const formStatus = ref<FormStatus>("sectional");

export const newPropertyForm = () => {
  const setFormStatus = (newStatus: FormStatus) => {
    formStatus.value = newStatus;
    console.log(formStatus.value);
  };
  return {
    formStatus,
    setFormStatus,
  };
};

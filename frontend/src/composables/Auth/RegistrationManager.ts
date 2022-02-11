import { reactive, ref } from "vue";
import AuthService from "@/services/AuthService";
import { IRegistrationPayload } from "@/Types/Auth";
import { useRouter } from "vue-router";
import GetError, { ResponseError } from "@/Helpers/GetError";

interface IRegistrationError {
  name?: string[];
  email?: string[];
  password?: string[];
  password_confirmation?: string[];
}

//TODO: Missing return type on function
export function RegistrationManager() {
  const registrationForm = reactive<IRegistrationPayload>({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
  });
  const validator = (rule: any, value: string, callback: any) => {
    if (value !== registrationForm.password) {
      callback(new Error("Passwords must match"));
    }
    callback();
  };
  const registrationValidator = reactive({
    email: [
      {
        type: "email",
        message: "Please enter a valid email address",
        trigger: ["blur"],
      },
      {
        required: true,
        message: "Email is required",
        trigger: ["blur"],
      },
    ],
    password: [
      {
        type: "string",
        min: 8,
        message: "Password should be at least 8 characters",
      },
      {
        required: true,
        message: "Password is required",
      },
    ],
    password_confirmation: [
      {
        required: true,
        message: "Password Confirmation is required",
        trigger: ["blur"],
      },
      {
        validator,
        trigger: ["blur", "change"],
      },
    ],
  });

  //Handle Registration
  const registering = ref(false);
  const registrationError = ref<IRegistrationError | undefined>();
  const register = async (
    payload: IRegistrationPayload = registrationForm
  ): Promise<boolean> => {
    registering.value = true;
    try {
      await AuthService.register(payload);
      registering.value = false;
      return true;
    } catch (error) {
      registering.value = false;
      registrationError.value = GetError(error as ResponseError);
      return false;
    }
  };

  //Handle login
  return {
    registrationForm,
    registering,
    registrationValidator,
    registrationError,
    register,
  };
}

import GetError, { ResponseError } from "@/Helpers/GetError";
import { IPotentialUserData } from "@/interfaces/User";
import UsersService from "@/services/UsersService";
import { reactive, ref } from "vue";

export interface INewUserData {
  agent_registration_number: string;
  is_admin: boolean;
  is_agent: boolean;
  is_tenant: boolean;
  bio: string;
  phone_number: string;
  email: string;
  name: string;
}

type INewUserError = INewUserData | undefined;

function getEmptyUser(): INewUserData {
  return {
    agent_registration_number: "",
    is_admin: false,
    is_agent: false,
    is_tenant: false,
    bio: "",
    phone_number: "",
    email: "",
    name: "",
  };
}

function processRole(role: string) {
  return {
    is_admin: role.toLowerCase() === "admin",
    is_agent: role.toLowerCase() === "agent",
    is_tenant: role.toLowerCase() === "tenant",
  };
}
const userValidator = reactive({
  email: [
    {
      type: "email",
      message: "Please enter a valid email address",
      trigger: ["blur", "change"],
    },
    {
      required: true,
      message: "Email is required",
      trigger: ["blur"],
    },
  ],
  name: [
    {
      required: true,
      message: "Name is required",
      trigger: ["blur"],
    },
  ],
});

export function manageNewUser() {
  const user = reactive<INewUserData>(getEmptyUser());
  const creatingUser = ref(false);
  async function createUser(user: INewUserData): Promise<boolean> {
    creatingUser.value = true;
    try {
      const response = await UsersService.create(user);
      if (response.status === 204) {
        creatingUser.value = false;
        return true;
      } else throw new Error("Failed to create user");
    } catch (error) {
      creatingUser.value = false;
      GetError(error as ResponseError);
      throw error;
    }
  }
  //
  function clearNewUsers() {
    Object.assign(user, getEmptyUser());
  }
  return {
    user,
    userValidator,
    creatingUser,
    createUser,
    processRole,
    getEmptyUser,
  };
}

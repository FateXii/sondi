import GetError, { ResponseError } from "@/Helpers/GetError";
import { IPotentialUserData } from "@/interfaces/User";
import UsersService from "@/services/UsersService";
import { reactive, ref } from "vue";

type INewUserError = INewUserData | undefined;
interface INewUserData {
  email: string;
  error?: INewUserError;
}

function getEmptyUser(): INewUserData {
  return {
    email: "",
  };
}

function processUserData(
  userData: INewUserData,
  role: string
): IPotentialUserData {
  return {
    email: userData.email,
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
      trigger: ["blur"],
    },
    {
      required: true,
      message: "Email is required",
      trigger: ["blur"],
    },
  ],
});

export function manageNewUser() {
  const newUsers = ref<INewUserData[]>([getEmptyUser()]);
  const creatingUser = ref(false);

  //
  function clearNewUsers() {
    newUsers.value = [getEmptyUser()];
  }
  function addUser(i: number) {
    newUsers.value.push(getEmptyUser());
  }
  async function createNewUsers(role: string) {
    let success = true;
    for (let index = 0; index < newUsers.value.length; index++) {
      const element = newUsers.value[index];
      creatingUser.value = true;
      try {
        await UsersService.create(processUserData(element, role));
        creatingUser.value = false;
        success = success && true;
      } catch (error) {
        creatingUser.value = false;
        newUsers.value[index].error = GetError(error as ResponseError);
        success = success && false;
      }
    }
    return success;
  }
  return {
    newUsers,
    addUser,
    clearNewUsers,
    createNewUsers,
    userValidator,
  };
}

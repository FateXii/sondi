import { useRouter } from "vue-router";
import { reactive, ref } from "vue";
import UsersService from "@/services/UsersService";
import GetError, { ResponseError } from "@/Helpers/GetError";
import { IAbreviatedUser, IUserRoles } from "@/Types/User";
import { IUserDataType } from "@/store/auth";

function diff(target: any, reference: any): any {
  const dataMap = new Map(Object.entries(target));
  Object.entries(reference).forEach(([key, value]) => {
    if (dataMap.has(key)) {
      if (dataMap.get(key) === value) {
        dataMap.delete(key);
      }
    }
  });
  return Object.fromEntries(dataMap.entries());
}

export function ManageUsers() {
  const user = ref<IUserDataType>();
  const pageLoading = ref(false);
  async function updateUser(id: number, data: any) {
    try {
      const response = await UsersService.update(id, data);
      if (response.status === 204) {
        return true;
      } else {
        throw new Error("Failed to update user");
      }
    } catch (error) {
      GetError(error as ResponseError);
      throw error;
    }
  }
  async function deleteUser(id: number) {
    try {
      const response = await UsersService.delete(id);
      if (response.status === 204) {
        return true;
      } else {
        throw new Error(`Failed to delete user`);
      }
    } catch (error) {
      GetError(error as ResponseError);
      throw error;
    }
  }
  const editing = ref(false);
  const editableUserData = reactive<IUserDataType>({
    agent_registration_number: "",
    is_admin: false,
    is_agent: false,
    is_tenant: false,
    bio: "",
    phone_number: "",
    email: "",
    id: -1,
    photo: "",
    name: "",
  });
  function handleUserDescriptionEdited(editedUserData: IAbreviatedUser) {
    Object.assign(editableUserData, editedUserData);
  }
  function handleAvatarEdited(userRoles: IUserRoles) {
    Object.assign(editableUserData, userRoles);
  }
  function toggleEditing() {
    editing.value = !editing.value;
  }
  return {
    toggleEditing,
    handleAvatarEdited,
    handleUserDescriptionEdited,
    deleteUser,
    updateUser,
    pageLoading,
    diff,
    editableUserData,
    user,
    editing,
  };
}

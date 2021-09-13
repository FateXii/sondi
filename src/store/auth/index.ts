import GetError, { ResponseError } from "@/Helpers/GetError";
import AuthService from "@/services/AuthService";
import { computed, reactive } from "vue";

type Option<T> = T | null;

export interface IUserDataType {
  id: number;
  agent_registration_number: string;
  is_admin: boolean;
  is_agent: boolean;
  is_tenant: boolean;
  photo: string;
  bio: string;
  phone_number: string;
  deleted_at?: string;
  email: string;
  name: string;
}
type ErrorType = any;
interface IAuthStore {
  user: Option<IUserDataType>;
  loading: boolean;
  error: ErrorType;
}

const state = reactive<IAuthStore>({
  user: null,
  loading: false,
  error: "",
});
function SetUser(user: Option<IUserDataType>): void {
  state.user = user;
}

function SetLoading(loading: boolean): void {
  state.loading = loading;
}

function SetError(error: ErrorType): void {
  state.error = error;
}

function SetGuest(guestStatus: string) {
  window.localStorage.setItem("guest", guestStatus);
}

function IsGuest() {
  const guestStatus = window.localStorage.getItem("guest");
  if (!guestStatus || guestStatus === "isNotGuest") return false;
  if (guestStatus === "isGuest") return true;
}

export async function GetAuthenticatedUser(): Promise<Option<IUserDataType>> {
  SetLoading(true);
  try {
    const response = await AuthService.getAuthUser();
    SetUser(response.data.data);
    SetLoading(false);
    return response.data;
  } catch (error) {
    SetLoading(false);
    SetUser(null);
    SetError(GetError(error as ResponseError));
  }
  return state.user;
}

const IsAdmin = () => state.user?.is_admin || false;
const IsAgent = () => state.user?.is_agent || false;
const IsAthenticated = computed(() => (state.user && true) || false);
const user = computed(() => state.user);
export default function useAuthStore() {
  return {
    IsAthenticated,
    user,
    IsAdmin,
    IsAgent,
    SetError,
    SetLoading,
    SetUser,
    IsGuest,
    SetGuest,
  };
}

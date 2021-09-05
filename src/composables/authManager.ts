import { computed, reactive, Ref, ref } from "vue";
import AuthService from "@/services/AuthService";
import { useRouter } from "vue-router";
import {
  IUser,
  IUserLoginData,
  IUserRegistrationData,
} from "@/interfaces/apiTypes";
import { use } from "element-plus/lib/locale";

function getError(e: any) {
  const errorMessage = "API Error, please try again.";
  if (e.response.data && e.response.data.errors) {
    return e.response.data.errors;
  }
  return errorMessage;
}
type Option<T> = undefined | T;

const authError = ref();
function setError(error: any) {
  authError.value = getError(error);
}

const user = ref<Option<IUser>>(undefined);

function setUser(newUser: Option<IUser>) {
  user.value = newUser;
}
function setGuest(guestStatus: string) {
  window.localStorage.setItem("guest", guestStatus);
}

function makeGuest() {
  setGuest("isGuest");
}

function unMakeGuest() {
  setGuest("isNotGuest");
}

export function isGuest() {
  const guestStatus = window.localStorage.getItem("guest");
  if (!guestStatus || guestStatus === "isNotGuest") return false;
  if (guestStatus === "isGuest") return true;
}
async function getAuthUser() {
  try {
    const { data } = await AuthService.getAuthUser();
    setUser(data);
    unMakeGuest();
  } catch (error) {
    setUser(undefined);
    makeGuest();
  }
  return user.value;
}

export const authManager = () => {
  const registering = ref(false);
  const loggingIn = ref(false);
  const loggingOut = ref(false);
  const router = useRouter();
  const registrationForm = reactive({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
  });
  const register = (payload: IUserRegistrationData = registrationForm) => {
    authError.value = null;
    registering.value = true;
    AuthService.register(payload)
      .then(() => {
        router.push("/dashboard");
        getAuthUser();
        registering.value = false;
      })
      .catch((apiError) => {
        setError(apiError);
        registering.value = false;
      });
  };
  const loginForm = reactive({
    email: "",
    password: "",
  });
  const login = async (payload: IUserLoginData = loginForm) => {
    authError.value = null;
    loggingIn.value = true;
    try {
      await AuthService.login(payload);
      const authUser = await getAuthUser();
      if (authUser) {
        router.push("/dashboard");
        loggingIn.value = false;
      } else {
        const apiError = Error(
          "Unable to fetch user after login, check your API settings."
        );
        apiError.name = "Fetch User";
        loggingIn.value = false;
        throw apiError;
      }
    } catch (apiError) {
      setError(apiError);
      loggingIn.value = false;
    }
  };
  const logout = () => {
    authError.value = null;
    loggingOut.value = true;
    AuthService.logout()
      .then(() => {
        setUser(undefined);
        setGuest("isGuest");
        loggingOut.value = false;
      })
      .catch((apiError) => {
        setError(apiError);
      });
  };
  return {
    loginForm,
    loggingIn,
    loggingOut,
    registrationForm,
    registering,
    user,
    loggedIn: computed(() => user.value !== undefined),
    isAdmin: computed(() => user.value && user.value.is_admin),
    getAuthUser,
    login,
    logout,
    register,
  };
};

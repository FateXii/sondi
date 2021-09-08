import { computed, reactive, Ref, ref } from "vue";
import AuthService from "@/services/AuthService";
import Auth, { GetAuthenticatedUser, IUserDataType } from "@/store/auth";
import { ILoginPayload, IRegisterPayload } from "@/interfaces/Auth";
import { useRouter } from "vue-router";
import {
  IUser,
  IUserLoginData,
  IUserRegistrationData,
} from "@/interfaces/apiTypes";
import GetError, { RespnseError } from "@/Helpers/GetError";

export const AuthManager = () => {
  const registering = ref(false);
  const logingIn = ref(false);
  const logingOut = ref(false);
  const router = useRouter();

  //Handle Registration
  const registrationError = ref(null);
  const registrationForm = reactive<IRegisterPayload>({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
  });
  const register = (payload: IUserRegistrationData = registrationForm) => {
    registrationError.value = null;
    registering.value = true;
    AuthService.register(payload)
      .then(() => {
        registering.value = false;
        router.push("/dashboard");
      })
      .catch((error) => {
        registering.value = false;
        registrationError.value = GetError(error as RespnseError);
      });
  };

  //Handle login
  const loginForm = reactive<ILoginPayload>({
    email: "",
    password: "",
  });
  const loginError = ref(null);
  const login = async (payload: ILoginPayload = loginForm) => {
    logingIn.value = true;
    try {
      await AuthService.login(payload);
      const authUser = await GetAuthenticatedUser();
      if (authUser) {
        logingIn.value = false;
        router.push("/dashboard");
      } else {
        const apiError = Error(
          "Unable to fetch user after login, check your API settings."
        );
        apiError.name = "Fetch User";
        logingIn.value = false;
        throw apiError;
      }
    } catch (error) {
      logingIn.value = false;
      loginError.value = GetError(error as RespnseError);
    }
  };

  //Handle Logout
  const logout = () => {
    logingOut.value = true;
    AuthService.logout()
      .then(() => {
        Auth.SetUser(null);
        Auth.SetGuest("isGuest");
        logingOut.value = false;
      })
      .catch((error) => {
        Auth.SetError(GetError(error as RespnseError));
      });
  };
  return {
    loginForm,
    logingIn,
    logingOut,
    registrationForm,
    registering,
    user: Auth.state.user || undefined,
    loggedIn: computed(() => Auth.state.user !== null),
    isAdmin: computed(() => Auth.state.user?.is_admin),
    login,
    logout,
    register,
  };
};

import { computed, reactive, Ref, ref } from "vue";
import AuthService from "@/services/AuthService";
import useAuthStore, {
  GetAuthenticatedUser,
  IUserDataType,
} from "@/store/auth";
import { ILoginPayload, IRegistrationPayload } from "@/interfaces/Auth";
import { useRouter } from "vue-router";
import GetError, { RespnseError } from "@/Helpers/GetError";

export const AuthManager = () => {
  const registering = ref(false);
  const loggingIn = ref(false);
  const loggingOut = ref(false);
  const router = useRouter();
  const Auth = useAuthStore();

  //Handle Registration
  const registrationError = ref(null);
  const registrationForm = reactive<IRegistrationPayload>({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
  });
  const register = (payload: IRegistrationPayload = registrationForm) => {
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
    loggingIn.value = true;
    try {
      await AuthService.login(payload);
      const authUser = await GetAuthenticatedUser();
      if (authUser) {
        loggingIn.value = false;
        router.push("/dashboard");
      } else {
        const apiError = Error(
          "Unable to fetch user after login, check your API settings."
        );
        apiError.name = "Fetch User";
        loggingIn.value = false;
        throw apiError;
      }
    } catch (error) {
      loggingIn.value = false;
      loginError.value = GetError(error as RespnseError);
    }
  };

  //Handle Logout
  const logout = () => {
    loggingOut.value = true;
    AuthService.logout()
      .then(() => {
        Auth.SetUser(null);
        Auth.SetGuest("isGuest");
        loggingOut.value = false;
      })
      .catch((error) => {
        Auth.SetError(GetError(error as RespnseError));
      });
  };
  return {
    loginForm,
    loggingIn,
    loginError,

    loggingOut,

    registrationForm,
    registering,
    user: Auth.user.value || undefined,
    loggedIn: computed(() => Auth.IsAthenticated),
    isAdmin: Auth.IsAdmin(),
    login,
    logout,
    register,
  };
};

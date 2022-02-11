import { computed, ref } from "vue";
import AuthService from "@/services/AuthService";
import useAuthStore from "@/store/auth";
import GetError, { ResponseError } from "@/Helpers/GetError";

//TODO: Missing return type on function
export function AuthManager() {
  const loggingOut = ref(false);
  const Auth = useAuthStore();

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
        Auth.SetError(GetError(error as ResponseError));
      });
  };
  return {
    logout,
    loggingOut,

    user: Auth.user.value || undefined,
    loggedIn: computed(() => Auth.IsAthenticated),
    isAdmin: Auth.IsAdmin(),
  };
}

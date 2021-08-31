import { computed, reactive, Ref, ref } from "vue";
import userApi from "@/services/user";
import { useRouter } from "vue-router";
import {
  IUser,
  IUserLoginData,
  IUserRegistrationData,
} from "@/interfaces/apiTypes";

type Option<T> = undefined | T;

const user = ref<Option<IUser>>(undefined);
export const checkUser = () => {
  userApi
    .get()
    .then((response) => {
      if (response.status === 200) {
        const { id, name, email } = response.data;
        user.value = {
          id,
          name,
          email,
        };
      }
      console.log(`then loggedIn: ${user.value?.name}`);
    })
    .catch((_) => {
      console.log(`catch loggedIn: ${user.value?.name}`);
    });
};

const loginForm = reactive({
  email: "",
  password: "",
});
const registrationForm = reactive({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});
export const authManager = () => {
  const registering = ref(false);
  const loggingIn = ref(false);
  const loggingOut = ref(false);
  const router = useRouter();
  const logout = () => {
    loggingOut.value = true;
    checkUser();
    if (user.value) {
      userApi
        .logout()
        .then((response) => {
          if (response.status === 204) {
            user.value = undefined;
            loggingOut.value = false;
          }
          router.push("/");
        })
        .catch((error) => {
          console.error(error);
          loggingOut.value = false;
        });
    }
    loggingOut.value = false;
  };
  const login = (data: IUserLoginData = loginForm) => {
    console.log("logging in");
    console.log(data);
    loggingIn.value = true;
    userApi
      .login(data)
      .then((response) => {
        if (response.status === 200) {
          loggingIn.value = false;
          checkUser();
          router.push("/dashboard");
        }
      })
      .catch((error) => {
        console.error(error);
        loggingIn.value = false;
      });
  };
  const register = (data: IUserRegistrationData = registrationForm) => {
    console.log(data);
    registering.value = true;
    userApi
      .register(data)
      .then((response) => {
        if (response.status === 201) {
          registering.value = false;
          const { email, password } = data;
          login({ email, password });
        }
      })
      .catch((error) => {
        console.error(error);
        registering.value = false;
      });
  };
  return {
    loginForm,
    login,
    loggingIn,
    logout,
    loggingOut,
    registrationForm,
    register,
    registering,
    user,
    loggedIn: computed(() => user.value !== undefined),
  };
};

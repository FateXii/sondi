<template>
  <el-container>
    <router-link to="/">
      <el-image :src="require('@/assets/logo.svg')"></el-image>
    </router-link>
    <el-form
      label-position="top"
      label-width="100px"
      :model="loginForm"
      :rules="loginValidator"
      ref="loginFormRef"
    >
      <h1>Login</h1>
      <el-alert
        title="Invalid Credential"
        type="error"
        show-icon
        v-for="(error, i) in errors"
        :key="i"
      >
        {{ error }}
      </el-alert>
      <el-alert
        title="Invalid input"
        type="error"
        show-icon
        v-if="validationError"
      ></el-alert>
      <el-form-item label="Email" prop="email">
        <el-input type="email" v-model="loginForm.email"></el-input>
      </el-form-item>
      <el-form-item label="Password" prop="password">
        <el-input type="password" v-model="loginForm.password"></el-input>
      </el-form-item>
      <el-form-item>
        <el-row>
          <el-button
            class="login-button"
            @click="loginUser"
            :loading="loggingIn"
            >{{ loggingIn ? "Logging In" : "Login" }}</el-button
          >
          <router-link to="/register">Register</router-link>
        </el-row>
      </el-form-item>
    </el-form>
  </el-container>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import { LoginManager } from "@/composables/Auth/LoginManager";
import GetError, { ResponseError } from "@/Helpers/GetError";
import { useRouter } from "vue-router";

export default defineComponent({
  setup() {
    const router = useRouter();
    const { login, loginForm, loggingIn, loginError, loginValidator } =
      LoginManager();
    const loginFormRef = ref();
    const validationError = ref(false);
    const errors = ref<string[]>([]);

    const loginUser = async () => {
      loginFormRef.value.validate((valid: boolean) => {
        validationError.value = !valid;
      });
      try {
        if (!validationError.value) {
          if (await login()) {
            router.push("/dashboard");
          }
        }
        if (loginError.value !== null) {
          errors.value = [
            ...((loginError.value && loginError.value.email) || []),
            ...((loginError.value && loginError.value.password) || []),
          ];
        }
      } catch (error) {
        GetError(error as ResponseError);
      }
    };
    return {
      loginUser,
      loginForm,
      loggingIn,
      loginValidator,
      errors,
      loginFormRef,
      validationError,
    };
  },
});
</script>

<style lang="scss" scoped>
.el-container {
  display: flex;
  align-items: center;
  flex-direction: column;
  .el-image {
    margin-bottom: 5rem;
  }
  .el-form {
    width: 100vw;
    padding: 1rem;
    box-shadow: none;
    // @media (min-width: 426px) {
    //   }
    @media (min-width: 601px) {
      box-shadow: 1px 1px 10px 0px #e6a23c, -1px -1px 10px 0px #e6a23c;
      width: 80vw;
    }
    @media (min-width: 769px) {
      width: 60vw;
    }
  }
}
.login-button {
  margin-right: 1rem;
}
</style>

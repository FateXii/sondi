<template>
  <el-container>
    <el-image :src="require('@/assets/logo.svg')"></el-image>
    <el-form
      label-position="top"
      label-width="100px"
      :model="registrationForm"
      :rules="registrationValidator"
      ref="registrationFormRef"
    >
      <h1>Registration</h1>
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
      <el-form-item label="Name" prop="name">
        <el-input type="text" v-model="registrationForm.name"></el-input>
      </el-form-item>
      <el-form-item label="Email" prop="email">
        <el-input type="email" v-model="registrationForm.email"></el-input>
      </el-form-item>
      <el-form-item label="Password" prop="password">
        <el-input
          type="password"
          v-model="registrationForm.password"
        ></el-input>
      </el-form-item>
      <el-form-item label="Confirm Password" prop="password_confirmation">
        <el-input
          type="password"
          v-model="registrationForm.password_confirmation"
        ></el-input>
      </el-form-item>
      <el-form-item>
        <el-row>
          <el-button
            class="register-button"
            @click="registerUser"
            :loading="registering"
          >
            {{ registering ? "Registering" : "Register" }}
          </el-button>
          <span> Already Registered? &nbsp; </span>
          <router-link to="/login"> Login</router-link>
        </el-row>
      </el-form-item>
    </el-form>
  </el-container>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import { RegistrationManager } from "@/composables/Auth/RegistrationManager";
import router from "@/router";
import GetError, { ResponseError } from "@/Helpers/GetError";

export default defineComponent({
  setup() {
    const {
      registrationError,
      registrationForm,
      register,
      registering,
      registrationValidator,
    } = RegistrationManager();

    const registrationFormRef = ref();
    const validationError = ref(false);
    const errors = ref<string[]>([]);

    const registerUser = async () => {
      registrationFormRef.value.validate((valid: boolean) => {
        validationError.value = !valid;
      });
      try {
        if (!validationError.value) {
          if (await register()) {
            router.push("/login");
          }
        }
        if (registrationError.value !== null) {
          errors.value = [
            ...((registrationError.value && registrationError.value.email) ||
              []),
            ...((registrationError.value && registrationError.value.password) ||
              []),
          ];
        }
      } catch (error) {
        GetError(error as ResponseError);
      }
    };
    return {
      registrationForm,
      registerUser,
      registering,
      registrationValidator,
      registrationFormRef,
      validationError,
      errors,
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
    @media (min-width: 601px) {
      box-shadow: 1px 1px 10px 0px #e6a23c, -1px -1px 10px 0px #e6a23c;
      width: 80vw;
    }
    @media (min-width: 769px) {
      width: 60vw;
    }
  }
}
.register-button {
  margin-right: 1rem;
}
</style>

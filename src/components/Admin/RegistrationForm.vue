<template>
  <el-container>
    <el-form label-position="top" label-width="100px" :model="registrationForm">
      <el-form-item label="Name">
        <el-input type="text" v-model="registrationForm.name"></el-input>
      </el-form-item>
      <el-form-item label="Email">
        <el-input type="email" v-model="registrationForm.email"></el-input>
      </el-form-item>
      <el-form-item label="Password">
        <el-input
          type="password"
          v-model="registrationForm.password"
        ></el-input>
      </el-form-item>
      <el-form-item label="Confirm Password">
        <el-input
          type="password"
          v-model="registrationForm.password_confirmation"
        ></el-input>
      </el-form-item>
      <el-form-item>
        <el-button
          @click="registerUser"
          :loading="registering || loggingIn"
          type="primary"
        >
          {{
            registering ? "Registering" : loggingIn ? "Logging In" : "Register"
          }}</el-button
        >
      </el-form-item>
    </el-form>
  </el-container>
</template>

<script lang="ts">
import { defineComponent, reactive } from "vue";
import { authManager } from "@/composables/authManager";

export default defineComponent({
  setup() {
    const { loggingIn, registrationForm, register, registering } =
      authManager();
    const registerUser = () => {
      register();
    };
    return {
      registrationForm,
      registerUser,
      registering,
      loggingIn,
    };
  },
});
</script>

<style lang="scss" scoped>
.el-container {
  display: flex;
  align-items: center;
  flex-direction: column;
  .el-form {
    width: 100vw;
    box-shadow: 1px 1px 10px 0px #e6a23c, -1px -1px 10px 0px #e6a23c;
    padding: 1rem;
    margin-top: 5rem;
    @media (min-width: 767px) {
      width: 60vw;
    }
  }
}
</style>

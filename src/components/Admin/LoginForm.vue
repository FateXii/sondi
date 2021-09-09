<template>
  <el-container>
    <el-form label-position="top" label-width="100px" :model="loginForm">
      <el-form-item label="Email">
        <el-input type="email" v-model="loginForm.email"></el-input>
      </el-form-item>
      <el-form-item label="Password">
        <el-input type="password" v-model="loginForm.password"></el-input>
      </el-form-item>
      <el-form-item>
        <el-row>
          <el-button @click="loginUser" type="primary" :loading="loggingIn">{{
            loggingIn ? "Logging In" : "Login"
          }}</el-button>
          <router-link to="/dashboard/register">register</router-link>
        </el-row>
      </el-form-item>
    </el-form>
  </el-container>
</template>

<script lang="ts">
import { defineComponent, onMounted, reactive } from "vue";
import { AuthManager } from "@/composables/AuthManager";
import { useRouter } from "vue-router";
import Auth, {GetAuthenticatedUser} from "@/store/auth"

export default defineComponent({
  setup() {
    const { login, user, loginForm, loggingIn, loginError } = AuthManager();
    const loginUser = () => {
      console.log("loginUser")
      login().then(() => {
        GetAuthenticatedUser().then(() =>  console.log("loggedIn"))
        }).catch(error => console.log(error));
    };
    const router = useRouter();
    onMounted(() => {
      if (user) {
        router.push("/dashboard");
      }
    });
    return {
      loginUser,
      loginForm,
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

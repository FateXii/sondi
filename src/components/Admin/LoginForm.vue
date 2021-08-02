<template>
  <el-container>
    <el-form label-position="top" label-width="100px" :model="formLabelAlign">
      <el-form-item label="Email">
        <el-input type="email" v-model="formLabelAlign.name"></el-input>
      </el-form-item>
      <el-form-item label="Password">
        <el-input type="password" v-model="formLabelAlign.region"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button @click="login" type="primary">Login</el-button>
      </el-form-item>
    </el-form>
  </el-container>
</template>

<script lang="ts">
import { defineComponent, reactive } from "vue";

export default defineComponent({
  setup() {
    const formLabelAlign = reactive({
      name: "",
      email: "",
      password: "",
    });
    return {
      formLabelAlign,
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

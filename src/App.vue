<template>
  <el-container id="app-container">
    <router-view />
  </el-container>
</template>

<script>
import { defineComponent, onMounted } from "vue";

export default defineComponent({
  name: "App",
  setup() {
    return {};
  },
});
</script>

<style scoped>
.el-container {
  justify-content: center;
  flex-flow: column nowrap;
}
#app-container {
  min-height: 100vh;
}
</style>

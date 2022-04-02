<template>
  <el-container id="app-container">
    <router-view />
  </el-container>
</template>

<script lang="ts">
import { defineComponent, onMounted, onUnmounted } from "vue";
import { onResize } from "./Helpers/GetScreenWidth";

export default defineComponent({
  name: "App",
  setup() {
    onMounted(() => {
      window.addEventListener("resize", onResize);
    });
    onUnmounted(() => {
      window.removeEventListener("resize", onResize);
    });
    return {};
  },
});
</script>

<style scoped>
.el-container {
  /* justify-content: center; */
  flex-flow: column nowrap;
}
#app-container {
  min-height: 100vh;
}
</style>

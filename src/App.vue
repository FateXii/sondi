<template>
  <el-container>
    <router-view />
  </el-container>
</template>

<script>
import { LOAD_PROPERTIES } from "./store/action-types";
import { defineComponent, onMounted } from "vue";
import { useStore } from "vuex";

export default defineComponent({
  name: "App",
  setup() {
    const store = useStore();
    onMounted(() => store.dispatch(LOAD_PROPERTIES));
    return {};
  },
});
</script>

<style scoped>
.el-container {
  justify-content: center;
  flex-flow: column nowrap;
}
</style>

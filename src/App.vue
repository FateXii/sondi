<template>
  <el-container>
    <router-view />
    <Footer />
  </el-container>
</template>

<script>
import { LOAD_PROPERTIES } from "./store/action-types";
import { defineComponent, onMounted } from "vue";
import { useStore } from "vuex";

import Footer from "@/components/Footer";

export default defineComponent({
  name: "App",
  components: {
    Footer,
  },
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

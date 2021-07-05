<template>
  <Header />
  <router-view />
</template>

<script>
import Header from "./components/Header.vue";
import { LOAD_PROPERTIES } from "./store/action-types";
import { defineComponent, onMounted } from "vue";
import { useStore } from "vuex";

export default defineComponent({
  name: "App",
  components: {
    Header,
  },
  setup() {
    const store = useStore();
    onMounted(() => store.dispatch(LOAD_PROPERTIES));
    return {};
  },
});
</script>

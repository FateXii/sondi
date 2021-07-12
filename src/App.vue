<template>
  <router-view />
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

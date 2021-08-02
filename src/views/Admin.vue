<template lang="html">
  <Header />
  <AdminPanel />
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Header from "@/components/Header.vue";
import AdminPanel from "@/components/Admin/AdminPanel.vue";
export default defineComponent({
  components: {
    AdminPanel,
    Header,
  },
  setup() {
    return {};
  },
});
</script>

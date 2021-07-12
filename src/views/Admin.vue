<template lang="html">
  <LoginForm v-if="!authenticated" />
  <div v-else>
    <Header />
    <AdminPanel />
  </div>
</template>

<script lang="ts">
import { computed, defineComponent } from "vue";
import { useStore } from "vuex";
import Header from "@/components/Header.vue";
import LoginForm from "@/components/Admin/LoginForm.vue";
import AdminPanel from "@/components/Admin/AdminPanel.vue";
export default defineComponent({
  components: {
    LoginForm,
    AdminPanel,
    Header,
  },
  setup() {
    const store = useStore();
    const authenticated = computed(() => store.state.authenticated);
    return {
      authenticated,
    };
  },
});
</script>

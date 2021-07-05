<template lang="html">
  <LoginForm v-if="!authenticated" />
  <AdminPanel v-else />
</template>

<script lang="ts">
import { computed, defineComponent } from "vue";
import { useStore } from "vuex";
import LoginForm from "@/components/auth/LoginForm.vue";
import AdminPanel from "@/components/auth/AdminPanel.vue";
export default defineComponent({
  components: {
    LoginForm,
    AdminPanel,
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

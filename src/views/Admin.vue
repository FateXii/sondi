<template lang="html">
  <Header />
  <router-view></router-view>
</template>

<script lang="ts">
import { defineComponent, onMounted } from "vue";
import Header from "@/components/Header.vue";
import { authManager, checkUser } from "@/composables/authManager";
import { useRouter } from "vue-router";
export default defineComponent({
  components: {
    Header,
  },
  setup() {
    const { user } = authManager();
    const router = useRouter();
    onMounted(() => {
      checkUser();
      if (!user.value) {
        router.push("/dashboard/login");
      }
    });
    return {};
  },
});
</script>

<template lang="html">
  <el-container
    id="main-container"
    v-loading="loading"
    element-loading-background="rgba(255, 255, 255, 1)"
  >
    <!-- <Header /> -->
    <router-view></router-view>
    <Footer />
  </el-container>
</template>

<script lang="ts">
import { defineComponent, onMounted, ref } from "vue";
// import Header from "@/components/Header.vue";
import Footer from "@/components/Footer.vue";
import { GetAuthenticatedUser } from "@/store/auth";
import { useRouter } from "vue-router";
export default defineComponent({
  components: {
    // Header,
    Footer,
  },
  setup() {
    const router = useRouter();
    const loading = ref(false);
    onMounted(async () => {
      loading.value = true;
      try {
        const user = await GetAuthenticatedUser();
        if (user) {
          loading.value = false;
        } else {
          throw new Error("Unauthenticated");
        }
      } catch (error) {
        loading.value = false;
        router.push("/login");
      }
    });
    return { loading };
  },
});
</script>
<style lang="scss" scoped>
#main-container {
  min-height: 100vh;
}
</style>

<template>
  <div>
    <Header />
    <main class="property">
      <router-view></router-view>
    </main>
    <Footer />
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Header from "@/components/Header.vue";
import Footer from "@/components/Footer.vue";

export default defineComponent({
  components: {
    Header,
    Footer,
  },
  setup() {
    return {};
  },
});
</script>

<style lang="scss" scoped></style>

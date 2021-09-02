<template lang="html">
  <Header />
  <router-view></router-view>
  <Footer />
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

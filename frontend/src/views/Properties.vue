<template>
  <div>
    <Header />
    <div class="property">
      <router-view></router-view>
    </div>
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

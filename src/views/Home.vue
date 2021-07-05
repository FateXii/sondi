<template>
  <main>
    <Hero />
    <Listings />
  </main>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Hero from "@/components/Hero.vue"; // @ is an alias to /src
import Listings from "@/components/Listings.vue"; // @ is an alias to /src

export default defineComponent({
  name: "Home",
  components: {
    Hero,
    Listings,
  },
  setup() {
    return {};
  },
});
</script>

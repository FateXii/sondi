<template>
  <div>
    <Header />
    <main>
      <Hero />
      <Listings />
    </main>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Header from "@/components/Header.vue"; // @ is an alias to /src
import Hero from "@/components/Hero.vue"; // @ is an alias to /src
import Listings from "@/components/Listings.vue"; // @ is an alias to /src

export default defineComponent({
  name: "Home",
  components: {
    Header,
    Hero,
    Listings,
  },
  setup() {
    return {};
  },
});
</script>

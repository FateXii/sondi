<template>
  <div>
    <!-- <Header /> -->
    <main>
      <Hero />
      <Process />
      <Listings />
      <contact />
    </main>
    <Footer />
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Header from "@/components/Header.vue"; // @ is an alias to /src
import Hero from "@/components/Hero.vue"; // @ is an alias to /src
import Listings from "@/components/Listings.vue"; // @ is an alias to /src
import Footer from "@/components/Footer.vue";
import Contact from "@/components/Contact.vue";
import Process from "@/components/Process.vue";
export default defineComponent({
  name: "Home",
  components: {
    // Header,
    Hero,
    Process,
    Listings,
    Footer,
    Contact,
  },
  setup() {
    return {};
  },
});
</script>

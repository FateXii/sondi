<template lang="html">
  <div class="process" id="how-to">
    <div class="process__description">
      <h1 class="process__description__heading">Find Your Dream Home.</h1>
      <div class="process__description__text">
        <p>
          At Sondi we pride ourselves on making the search for a home quick, and
          painless.
        </p>
        <p>
          This is done by allowing you to search for the home of your dreams
          simply by filling in all your requirements into the search fields
          below.
        </p>
      </div>
    </div>
    <process-cards class="process__cards"></process-cards>
    <div class="process__cta">
      Find You Dream Home
      <el-button type="warning" @click="router.push('/properties')"
        >Properties</el-button
      >
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import ProcessCards from "@/components/Process/ProcessCards.vue";
import { useRouter } from "vue-router";
export default defineComponent({
  components: {
    ProcessCards,
  },
  setup() {
    const router = useRouter();
    return { router };
  },
});
</script>
<style lang="scss" scoped>
.process {
  background-image: url("../assets/ProcessBackground.jpg");
  background-size: cover;
  background-position: 0 0;
  display: grid;
  padding: 1rem;
  &__description {
    padding: 1rem;
    text-align: center;
    @media screen and (min-width: 1023px) {
      grid-column: 2 / span 2;
      grid-row: 1;
    }
    &__heading {
      font-size: 3rem;
    }
    &__text {
      font-size: 1.5rem;
    }
  }
  &__cards {
    @media screen and (min-width: 1023px) {
      grid-column: 2 / span 2;
      grid-row: 2;
    }
    @media screen and (min-width: 1439px) {
      grid-column: 3;
    }
  }
  &__cta {
    @media screen and (min-width: 1023px) {
      grid-column: 2 / span 2;
      text-align: center;
      margin-top: 4rem;
    }
  }
  @media screen and (min-width: 1023px) {
    min-height: 50vw;
    background-image: url("../assets/ProcessBackground.jpg");
    background-position: 0 0;
    background-size: cover;
    grid-template-columns: [line1] 8.75rem [line2] auto [line3] 40vw [line4] 8.75rem[end];
    grid-template-rows: [line1] auto [line2] auto [line3] 8.75rem [end];
  }
  @media screen and (min-width: 1440px) {
    background-position: 0 -25vh;
  }
  @media screen and (min-width: 1919px) {
    background-image: url("../assets/background-2462430.jpg");
    background-position: 0 -45rem;
    background-size: cover;
  }
}
</style>

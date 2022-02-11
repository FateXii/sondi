<template lang="html">
  <el-container>
    <div class="hero">
      <Header class="hero__header" />
      <div class="hero__text">
        <span>Everyone Can Afford Us.</span>
      </div>
      <div class="hero__cta">
        <span class="hero__cta__label">Find out more</span>
        <div class="hero__cta__buttons">
          <router-link to="\#contact">
            <el-button type="warning"> Contact Us</el-button>
          </router-link>
        </div>
      </div>
    </div>
  </el-container>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Header from "@/components/Header.vue";

export default defineComponent({
  components: {
    Header,
  },
  setup() {},
});
</script>

<style lang="scss" scoped>
.hero {
  background-image: url("../assets/hero_background.jpg");
  width: 100%;
  height: 100vh;
  display: grid;
  color: white;
  background-position: 75rem 0;
  &__header {
    @media (min-width: 767px) {
      grid-column: 2 / span 1;
    }
    @media (min-width: 992px) {
      grid-column: 2 / span 3;
    }
    @media (min-width: 1439px) {
      grid-column: 3 / span 1;
    }
  }
  @media (min-width: 767px) {
    background-position: 0 -20rem;
    grid-template-columns: [line1] 8.75rem [line2] auto [line3] 8.75rem [end];
    grid-template-rows: [line1] 25% [line2] 100px [line3] auto [line4] 100px [line5] 25% [end];
    color: white;
  }
  @media (min-width: 992px) {
    grid-template-columns: [line1] 8.75rem [line2] 8.75rem [line3] auto [line4] 8.75rem [line5] 8.75rem [end];
    grid-template-rows: [line1] 25% [line2] 100px [line3] auto [line4] 100px [line5] 25% [end];
  }
  &__text {
    font-size: 3.4375em;
    display: flex;
    align-items: center;
    flex-direction: column;
    grid-row: 3;
    text-align: center;
    @media (min-width: 767px) {
      align-items: flex-start;
      grid-column: 2 / span 1;
      text-align: left;
    }
    @media (min-width: 992px) {
      grid-column: 3 / span 1;
    }
  }
  &__cta {
    display: flex;
    flex-flow: column nowrap;
    align-items: center;
    grid-row: 5 / span 2;
    @media screen and (min-width: 767px) {
      flex-flow: row nowrap;
      align-items: center;
      grid-column: 2 / span 1;
      grid-row: 4;
      @media (min-width: 992px) {
        grid-column: 3 / span 1;
      }
    }
    &__label {
      font-size: 1.5em;
      margin-bottom: 2.5rem;
      @media screen and (min-width: 767px) {
        margin: 0rem 1rem 0 0;
      }
    }
    &__buttons {
      display: flex;
      flex-direction: column;
      font-size: 2.25em;
      font-weight: 600;
      @media screen and (min-width: 767px) {
        flex-direction: row;
      }
    }
  }
}
</style>

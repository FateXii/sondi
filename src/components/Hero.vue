<template>
  <el-container>
    <div class="hero">
      <div class="hero__text">
        <span>Property.</span>
        <span>Simplified!</span>
      </div>
      <div class="hero__cta">
        <span class="hero__cta__label">Find out more about</span>
        <div class="hero__cta__buttons">
          <span
            class="cta hero__cta__buttons__buying"
            v-on:click="setBuyingFlag(true)"
          >
            <router-link to="#buying"> Buying </router-link>
          </span>
          <span
            class="cta hero__cta__buttons__renting"
            v-on:click="setBuyingFlag(false)"
          >
            <router-link to="#renting"> Renting </router-link>
          </span>
        </div>
      </div>
    </div>
  </el-container>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import { SET_BUYING_FLAG } from "../store/mutation-types";

export default defineComponent({
  setup() {
    const store = useStore();
    const router = useRouter();
    const setBuyingFlag = (flag: boolean) => {
      store.commit(SET_BUYING_FLAG, flag);
      const route = flag ? "#buying" : "#renting";
      router.push(route);
    };
    return {
      setBuyingFlag,
    };
  },
});
</script>

<style lang="scss" scoped>
.cta {
  background-color: #f5e1bf;
  color: black;
  text-align: center;
  display: inline;
  line-height: 1em;
  border-radius: 6rem;
  padding: 1.5rem 3.5rem;
  cursor: pointer;
}
.hero {
  background-image: url("../assets/hero_background.jpg");
  width: 100%;
  height: 56rem;
  display: grid;
  background-position: 75rem 0;
  color: white;
  &__text {
    font-size: 3.4375em;
    display: flex;
    align-items: center;
    flex-direction: column;
    grid-row: 3;
  }
  &__cta {
    display: flex;
    flex-direction: column;
    align-items: center;
    grid-row: 5 / span 2;
    &__label {
      font-size: 1.5em;
      margin-bottom: 2.5rem;
    }
    &__buttons {
      display: flex;
      flex-direction: column;
      font-size: 2.25em;
      font-weight: 600;
      &__renting,
      &__buying {
        margin: 0.5rem 0;
      }
    }
  }
  @media (min-width: 767px) {
    background-position: 0;
    grid-template: 8.75rem / 8.75rem;
    color: white;
    &__text {
      font-size: 3.4375em;
      display: flex;
      align-items: flex-start;
      flex-direction: column;
      grid-column: 2 / span 2;
      grid-row: 3;
    }
    &__cta {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      grid-column: 2 / span 2;
      grid-row: 5;
      &__label {
        font-size: 1.5em;
        margin-bottom: 2.5rem;
      }
      &__buttons {
        display: flex;
        flex-direction: row;
        font-size: 2.25em;
        font-weight: 600;
        &__renting,
        &__buying {
          margin-right: 2.5rem;
        }
      }
    }
  }
}
</style>

<style lang="scss">
a {
  text-decoration: none;
}
</style>

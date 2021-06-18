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
          <a class="cta hero__cta__buttons__buying" href="#">
            Buying
          </a>
          <a class="cta hero__cta__buttons__renting" href="#">
            Renting
          </a>
        </div>
      </div>
    </div>
  </el-container>
</template>

<script lang="ts">
import { defineComponent } from '@vue/composition-api'

export default defineComponent({
  setup() {
    
  },
})
</script>

<style lang="scss" scoped>
.cta {
  background-color: #F5E1BF;
  color: black;
  text-align:center;
  display: inline;
  line-height: 1em;
  border-radius: 6rem;
  padding:1.5rem 5.5rem;
  text-decoration: none;
}
.hero {
  background-image: url('/sondi-frontend/hero_background.jpg');
  width:100%;
  height:50rem;
  background-position: -17.1rem 0;
  display: grid;
  grid-template: 8.75rem  / 8.75rem ;
  color:white;
  &__text {
    font-size:3.4375em;
    display:flex;
    flex-direction: column;
    grid-column: 2 / span 2;
    grid-row:3;
  }
  &__cta {
    display: flex;
    flex-direction: column;
    grid-column: 2 / span 2;
    grid-row:5;
    &__label {
      font-size:1.5em;
      margin-bottom: 2.5rem;
    }
    &__buttons {
      display: flex;
      font-size: 2.25em;;
      font-weight: 600;
      .cta {
        padding:1.5rem 6.25rem;
      }
      &__renting, &__buying {
        margin-right: 2.5rem;
      }
    }
  }
}

</style>

<style lang="scss">
.cta {
  background-color: #F5E1BF;
  color: black;
  text-align:center;
  display: inline;
  line-height: 1em;
  border-radius: 6rem;
  padding:1.5rem 5.5rem;
  text-decoration: none;
}
</style>

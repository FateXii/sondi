<template>
  <div class="container">
    <Header/>
    <h1>You have selected the following properties to view</h1>
    <div>
      <div class="viewings" v-for="item in 5" :key="item">
        <PropertyCard class="viewings__card"/>
        <PropertyDescription class="viewings__description"/>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from '@vue/composition-api'

export default defineComponent({
  setup() {
    
  },
})
</script>

<style lang="scss" scoped>
.container {
  padding: 5rem 8rem 1rem 8rem;
}
.viewings {
  display: flex;
  flex-flow: row nowrap;
  padding:2rem 0;
  align-items: center;
  &__description {
    margin: 0 1rem;
  }
}
</style>

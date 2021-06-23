<template>
  <div class="icon">
    <img :src="iconLocation" :alt="altIconDescription" class="icon__image"/>
    <div class="icon__label">{{iconLabel}}</div>
  </div>
</template>

<script lang="ts">
import {  defineComponent,   } from '@vue/composition-api'

export default defineComponent({
  props: {
    iconLocation: {
      type: String,
      required: true,
    },
    altIconDescription: {
      type: String,
      required: true,
    },
    iconLabel: {
      type: String,
      required: true,
    },
  },
})
</script>

<style lang="scss" scoped>
.icon {
  display:flex;
  flex-direction: column;
  align-items: center;
  width: fit-content;
  &__image {
    width:5rem;
    height:5rem;
  }
  &icon__label {
    width: fit-content;
  }
}
</style>

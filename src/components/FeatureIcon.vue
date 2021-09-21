<template>
  <div class="stats__container" :v-if="value > 0">
    <span class="stats__container__number">{{ value }}</span>
    <img
      :src="require(`@/assets/icons/${icon}`)"
      class="stats__container__icon"
      alt="location droppoint"
    />
  </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
export default defineComponent({
  props: {
    value: {
      type: Number,
      required: true,
    },
    icon: {
      type: String,
      required: true,
    },
  },
});
</script>
<style lang="scss" scoped>
.stats {
  display: flex;
  flex-flow: row nowrap;
  align-items: center;
  &__container {
    display: flex;
    flex-flow: row nowrap;
    align-items: center;
    padding: 0 1rem 0 0;
    &__number {
      font-size: 1.5rem;
      padding: 0 0.5rem 0 0;
    }
    &__icon {
      height: 2rem;
      width: 2rem;
    }
  }
}
</style>

<template lang="html">
  <div class="button">
    <i :if="icon" :class="[icon, `button__icon`]"></i>
    <span class="button__text">{{ label }}</span>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  name: "BoxButton",
  props: {
    icon: String,
    label: String,
  },
  setup() {
    return {};
  },
});
</script>
<style scoped lang="scss">
.button {
  display: flex;
  flex-flow: column nowrap;
  background-color: #e6a23c;
  color: white;
  width: 8rem;
  height: 8rem;
  margin: 1rem 0;
  border-radius: 10%;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  &:hover {
    background-color: #e6a23ce0;
  }
  &__icon::before {
    height: 2rem;
    width: 2rem;
  }
  @media (min-width: 767px) {
    &:nth-child(even) {
      margin: 1rem;
    }
  }
}
</style>

<template lang="html">
  <div>
    <div class="process-card">
      <div class="process-card__header">
        <Icon
          :icon-location="iconLocation"
          :alt-icon-description="altIconDescription"
        />
      </div>
      <div class="process-card__description">
        <div class="process-card__description__heading" v-if="iconLabel">
          <h1>{{ iconLabel }}</h1>
        </div>
        <div class="process-card__description__text">
          <slot></slot>
        </div>
      </div>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import Icon from "@/components/Icon.vue";

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
      // required: true,
    },
  },
  components: { Icon },
});
</script>
<style lang="scss"></style>

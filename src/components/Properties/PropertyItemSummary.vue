<template>
  <el-collapse-transition>
    <el-container v-if="summary">
      <el-image :src="property.cover_image" fit="fit"></el-image>
      <div class="property-summary">
        <h3 class="property-summary__price">
          {{ currencyFormatter.format(property.price) }}
        </h3>
        <h4 class="property-summary__title">
          {{ property.description_title }}
        </h4>
        <p class="property-summary__text">
          {{ property.description }}
        </p>
      </div>
    </el-container>
  </el-collapse-transition>
</template>
<script lang="ts">
import { IProperty } from "@/interfaces/Property";
import { defineComponent, PropType } from "vue";
const currencyFormatter = new Intl.NumberFormat("en-ZA", {
  currency: "ZAR",
  style: "currency",
});
export default defineComponent({
  props: {
    property: {
      type: Object as PropType<IProperty>,
      required: true,
    },
    summary: {
      type: Boolean,
      required: true,
    },
  },
  setup(props) {
    return {
      currencyFormatter,
    };
  },
});
</script>
<style lang="scss" scoped>
.el-container {
  display: flex;
  flex-flow: column nowrap;
}
.property-summary {
  padding: 0 1.5rem;
}
</style>

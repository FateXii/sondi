<template>
  <el-container class="property-list__item">
    <property-item-summary
      :summary="summary"
      :property="property"
      v-if="summary"
    />
    <property-detail v-else :property="property" />
    <el-button @click="showDetail" icon="el-icon-arrow-down" circle></el-button>
  </el-container>
</template>

<script lang="ts">
import { IProperty } from "@/interfaces/Property";
import { defineComponent, PropType, ref } from "vue";
import PropertyDetail from "./PropertyDetail.vue";
import PropertyItemSummary from "./PropertyItemSummary.vue";

export default defineComponent({
  components: { PropertyItemSummary, PropertyDetail },
  props: {
    property: {
      type: Object as PropType<IProperty>,
      required: true,
    },
  },
  setup() {
    const summary = ref(true);
    function showDetail() {
      summary.value = !summary.value;
      return;
    }
    return {
      summary,
      showDetail,
    };
  },
});
</script>
<style lang="scss" scoped>
.property-list__item {
  display: flex;
  flex-flow: column nowrap;
  align-items: center;
  padding: 0.75rem 0;
}
</style>

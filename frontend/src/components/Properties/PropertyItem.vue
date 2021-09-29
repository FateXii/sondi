<template>
  <el-container class="property-list__item">
    <property-item-summary
      :summary="summary"
      :property="property"
      v-if="summary"
    />
    <el-button @click="showDetail">See More</el-button>
  </el-container>
</template>

<script lang="ts">
import { IProperty } from "@/Types/Property";
import { defineComponent, PropType, ref, toRefs } from "vue";
import { useRouter } from "vue-router";
import PropertyItemSummary from "./PropertyItemSummary.vue";

export default defineComponent({
  components: { PropertyItemSummary },
  props: {
    property: {
      type: Object as PropType<IProperty>,
      required: true,
    },
  },
  setup(props) {
    const { property } = toRefs(props);
    const router = useRouter();
    const summary = ref(true);
    function showDetail() {
      router.push(`/properties/${property.value.id}`);
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

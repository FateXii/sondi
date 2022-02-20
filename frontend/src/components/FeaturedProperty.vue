<template lang="html">
  <el-image :src="property.cover_image" fit="cover"></el-image>
</template>
<script lang="ts">
import { IProperty } from "@/Types/Property";
import { defineComponent, PropType } from "vue";

export default defineComponent({
  props: {
    property: {
      type: Object as PropType<IProperty>,
      required: true,
    },
  },
  setup() {
    return {};
  },
});
</script>

<template lang="html">
  <el-carousel indicator-position="none" :autoplay="false" arrow="always">
    <el-carousel-item v-for="image in images.list" :key="image">
      <el-image :src="image" fit="cover"></el-image>
    </el-carousel-item>
  </el-carousel>
</template>

<script lang="ts">
import { List } from "@/Types";
import { defineComponent, PropType } from "vue";

export default defineComponent({
  props: {
    images: {
      type: Object as PropType<List<string>>,
      required: true,
    },
  },
  setup() {
    return {};
  },
});
</script>

<style scoped></style>

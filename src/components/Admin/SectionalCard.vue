<template lang="html">
  <el-card>
    <img
      src="https://th.bing.com/th/id/OIP.VjZgsBLSmRComw8zgXA8QgHaEU?pid=ImgDet&rs=1"
      class="image"
    />
    <div style="padding: 14px">
      <span>Some Property</span>
      <div class="bottom">
        <el-button
          @click="selectSectionalProperty"
          type="primary"
          class="button"
          >Add Property</el-button
        >
      </div>
    </div>
  </el-card>
</template>

<script lang="ts">
import { defineComponent } from "vue";
export default defineComponent({
  emits: ["selectedSectionalProperty"],
  setup(_, { emit }) {
    const selectSectionalProperty = () => {
      emit("selectedSectionalProperty");
    };
    return {
      selectSectionalProperty,
    };
  },
});
</script>

<style lang="scss" scoped>
.el-card {
  width: fit-content;
  img {
    width: 15rem;
  }
}
</style>

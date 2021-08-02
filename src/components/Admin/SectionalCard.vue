<template lang="html">
  <el-card>
    <img :src="setImageHost(sectionalProperty.image)" class="image" />
    <div style="padding: 14px">
      <span>{{ sectionalProperty.name }}</span>
      <div class="bottom">
        <el-button
          @click="selectSectionalProperty"
          type="primary"
          class="button"
          >Add New Unit</el-button
        >
      </div>
    </div>
  </el-card>
</template>

<script lang="ts">
import { defineComponent, PropType } from "vue";
import { ISectionalPropertyModel } from "@/interfaces/apiTypes";

export default defineComponent({
  emits: ["selectedSectionalProperty"],
  props: {
    sectionalProperty: {
      type: Object as PropType<ISectionalPropertyModel>,
    },
  },
  setup(props, { emit }) {
    const selectSectionalProperty = () => {
      emit("selectedSectionalProperty", props.sectionalProperty);
    };
    const setImageHost = (image: string) => {
      return `${process.env.VUE_APP_API_HOST}${image}`;
    };
    return {
      selectSectionalProperty,
      setImageHost,
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

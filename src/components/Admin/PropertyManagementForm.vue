<template lang="html">
  <el-scroll-bar max-height="400px">
    <el-form v-model="current" label-position="top">
      <el-form-item label="Name">
        <el-input v-model="current.name" autocomplete="off"></el-input>
      </el-form-item>
      <el-form-item label="Description">
        <el-input v-model="current.description" type="textarea"></el-input>
      </el-form-item>
      <el-form-item label="Bedrooms">
        <el-input-number v-model="current.beds"></el-input-number>
      </el-form-item>
      <el-form-item label="Bathrooms">
        <el-input-number v-model="current.baths"></el-input-number>
      </el-form-item>
      <el-form-item label="Garages">
        <el-input-number v-model="current.garages"></el-input-number>
      </el-form-item>
      <el-form-item label="For Sale">
        <el-checkbox v-model="current.buying">For Sale</el-checkbox>
      </el-form-item>
      <el-form-item label="Images">
        <input
          type="file"
          multiple
          accept="image/*"
          @change="setPropertyImages"
        />
      </el-form-item>
    </el-form>
  </el-scroll-bar>
</template>

<script lang="ts">
import { watchEffect, defineComponent, ref, toRef, PropType } from "vue";
import { Property } from "@/interfaces";
import { UploadFile } from "@/types";

import managePropertyModal from "@/composables/managePropertyModal";

export default defineComponent({
  props: {
    property: {
      type: Object as PropType<Property>,
    },
  },
  setup(props) {
    const property = toRef(props, "property");
    const { makeProperty } = managePropertyModal();
    const current = ref(makeProperty(property));
    watchEffect(() => {
      current.value = makeProperty(property);
      console.log(current);
    });
    const handleRemove = (file: UploadFile) => {
      console.log(file);
    };
    const handlePictureCardPreview = (file: UploadFile) => {
      dialogImageUrl.value = file.url || "";
      dialogVisible.value = true;
    };
    const handleDownload = (file: UploadFile) => {
      console.log(file);
    };
    const dialogImageUrl = ref("");
    const dialogVisible = ref(false);
    const disabled = ref(false);
    return {
      dialogImageUrl,
      dialogVisible,
      disabled,
      handleDownload,
      handlePictureCardPreview,
      handleRemove,
      current,
    };
  },
});
</script>

<style lang="scss" scoped>
.el-form {
  height: 70vh;
  overflow-y: scroll;
  padding: 0 2.5rem;
}
</style>

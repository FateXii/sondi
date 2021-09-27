<template>
  <el-upload
    action="#"
    list-type="picture-card"
    :auto-upload="false"
    accept="image/*"
    ref="uploadedImages"
    multiple
  >
    <template #default>
      <i class="el-icon-plus"></i>
    </template>
    <template #file="{ file }">
      <div class="upload-thumbnail-container">
        <img class="el-upload-list__item-thumbnail" :src="file.url" alt="" />
        <span class="el-upload-list__item-actions">
          <span
            class="el-upload-list__item-preview"
            @click="handlePictureCardPreview(file.url)"
          >
            <i class="el-icon-zoom-in"></i>
          </span>
          <span
            v-if="!disabled"
            class="el-upload-list__item-delete"
            @click="handleRemoveMulti(file)"
          >
            <i class="el-icon-delete"></i>
          </span>
        </span>
      </div>
    </template>
  </el-upload>
</template>

<script lang="ts">
import { ElFile } from "@/interfaces";
import { ElUpload } from "element-plus";
import { defineComponent, ref } from "vue";

export default defineComponent({
  setup() {
    const uploadedImages = ref<typeof ElUpload>();
    const dialogImageUrl = ref("");
    const dialogVisible = ref(false);
    function handlePictureCardPreview(file: string) {
      dialogImageUrl.value = file;
      dialogVisible.value = true;
    }
    function handleRemoveMulti(file: ElFile) {
      if (uploadedImages.value) {
        uploadedImages.value.uploadFiles =
          uploadedImages.value.uploadFiles.filter(
            (currentFile: ElFile) => currentFile.uid !== file.uid
          );
      }
    }
    return {
      handleRemoveMulti,
      handlePictureCardPreview,
      uploadedImages,
    };
  },
});
</script>

<template>
  <el-upload
    action="#"
    list-type="picture-card"
    :auto-upload="false"
    accept="image/*"
    ref="uploadedImages"
    @change="handleChange"
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
import { NewList } from "@/Helpers";
import { List } from "@/Types";
import { UploadFile } from "element-plus/lib/components/upload/src/upload.type";
import { defineComponent, reactive, ref, watch } from "vue";

export default defineComponent({
  emits: {
    uploadedImagesChange: (files: UploadFile[]): files is UploadFile[] => {
      if (files) {
        return true;
      } else {
        console.error("Not ELFILE");
        return false;
      }
    },
  },
  setup(_, { emit }) {
    const uploadedImages = reactive<List<UploadFile>>(NewList());
    const dialogImageUrl = ref("");
    const dialogVisible = ref(false);
    function handlePictureCardPreview(file: string) {
      dialogImageUrl.value = file;
      dialogVisible.value = true;
    }
    function handleRemoveMulti(file: UploadFile) {
      if (uploadedImages.list) {
        uploadedImages.list = uploadedImages.list.filter(
          (currentFile: UploadFile) => currentFile.uid !== file.uid
        );
      }
    }
    watch(uploadedImages, ({ list }) => {
      emit("uploadedImagesChange", list);
    });
    function handleChange(file: UploadFile) {
      uploadedImages.list.push(file);
    }
    return {
      handleRemoveMulti,
      handlePictureCardPreview,
      uploadedImages,
      handleChange,
    };
  },
});
</script>

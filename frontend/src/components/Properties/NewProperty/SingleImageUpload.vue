<template>
  <el-upload
    class="avatar-uploader"
    action="#"
    :show-file-list="false"
    :auto-upload="false"
    :on-change="handleOnChange"
  >
    <img v-if="imageUrl" :src="imageUrl" class="avatar" style="width: 100%" />
    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
  </el-upload>
</template>
<script lang="ts">
import { ElUpload } from "element-plus";
import { defineComponent, ref } from "vue";

export default defineComponent({
  emits: {
    onImageChange: (file: any) => (file && true) || false,
  },
  setup(_, { emit }) {
    const uploadedCoverImage = ref<typeof ElUpload>();
    const disabled = ref(false);
    const image = ref();
    const imageUrl = ref("");

    function handleOnChange(file: any) {
      image.value = file.raw;
      imageUrl.value = URL.createObjectURL(file.raw);
      emit("onImageChange", file);
    }
    return {
      handleOnChange,
      uploadedCoverImage,
      disabled,
      image,
      imageUrl,
    };
  },
});
</script>

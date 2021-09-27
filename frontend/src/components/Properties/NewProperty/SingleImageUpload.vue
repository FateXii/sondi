<template>
  <el-upload
    class="property-cover-image"
    action="#"
    accept="image/*"
    :show-file-list="false"
    :auto-upload="false"
    :on-change="handleOnChange"
  >
    <div v-if="imageUrl">
      <img :src="imageUrl" class="avatar" style="width: 100%" />
    </div>
    <div v-else class="property-cover-image__icon">New Image</div>
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

<style lang="scss" scoped>
.property-cover-image {
  &__icon {
    display: flex;
    flex-flow: column;
    align-items: center;
    justify-content: center;
    height: 9.25rem;
    width: 9.25rem;
    border-radius: 0.5rem;
    border: 1px dashed lightblue;
  }
}
</style>

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
        <el-upload
          action="#"
          multiple
          list-type="picture-card"
          :auto-upload="false"
        >
          <template #default>
            <i class="el-icon-plus"></i>
          </template>
          <template #file="{ file }">
            <div>
              <img
                class="el-upload-list__item-thumbnail"
                :src="file.url"
                alt=""
              />
              <span class="el-upload-list__item-actions">
                <span
                  class="el-upload-list__item-preview"
                  @click="handlePictureCardPreview(file)"
                >
                  <i class="el-icon-zoom-in"></i>
                </span>
                <span
                  v-if="!disabled"
                  class="el-upload-list__item-delete"
                  @click="handleDownload(file)"
                >
                  <i class="el-icon-download"></i>
                </span>
                <span
                  v-if="!disabled"
                  class="el-upload-list__item-delete"
                  @click="handleRemove(file)"
                >
                  <i class="el-icon-delete"></i>
                </span>
              </span>
            </div>
          </template>
        </el-upload>
        <el-dialog v-model="dialogVisible">
          <img width="100%" :src="dialogImageUrl" alt="" />
        </el-dialog>
      </el-form-item>
    </el-form>
  </el-scroll-bar>
</template>

<script lang="ts">
import {
  watchEffect,
  PropType,
  defineComponent,
  ref,
  reactive,
  toRef,
} from "vue";
import { Property } from "@/interfaces";

export default defineComponent({
  props: {
    property: {
      type: Object as PropType<Property>,
    },
  },
  setup(props) {
    const property = toRef(props, "property");
    const current = reactive({
      id: property.value?.id || Number(),
      location: property.value?.location || "",
      description: property.value?.description || "",
      beds: property.value?.beds || Number(),
      baths: property.value?.baths || Number(),
      garages: property.value?.garages || Number(),
      buying: property.value?.buying || Boolean(),
      imageList: property.value?.imageList || {
        coverImage: "",
        allImages: Array<string>(),
      },
      price: property.value?.price || Number(),
      name: property.value?.name || "",
      interested: property.value?.interested || Boolean(),
    });

    watchEffect(() => {
      current.id = property.value?.id || Number();
      current.location = property.value?.location || "";
      current.description = property.value?.description || "";
      current.beds = property.value?.beds || Number();
      current.baths = property.value?.baths || Number();
      current.garages = property.value?.garages || Number();
      current.buying = property.value?.buying || Boolean();
      current.imageList.coverImage = property.value?.imageList.coverImage || "";
      current.imageList.allImages = property.value?.imageList.allImages || [];
      current.price = property.value?.price || Number();
      current.name = property.value?.name || "";
      current.interested = property.value?.interested || Boolean();
      console.log(current);
    });
    const handleRemove = (file: any) => {
      console.log(file);
    };
    const handlePictureCardPreview = (file: any) => {
      dialogImageUrl.value = file.url;
      dialogVisible.value = true;
    };
    const handleDownload = (file: any) => {
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

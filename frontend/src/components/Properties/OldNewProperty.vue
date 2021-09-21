<template>
  <el-container>
    <el-form :model="property" label-position="top" class="property-form">
      <h1>Create New Property</h1>
      <el-collapse v-model="activeFormItem" accordion>
        <el-collapse-item
          class="property-form__description"
          title="Description"
          name="type"
        >
          <el-form-item class="property-form__description__title" label="Title">
            <el-input v-model="property.title"></el-input>
          </el-form-item>
          <el-form-item
            class="property-form__description__property-type"
            label="Property Type"
          >
            <el-select v-model="property.type" placeholder="Property Type">
              <el-option
                v-for="item in DATA.propertyTypes"
                :label="item.label"
                :value="item.value"
                :key="item.value"
              ></el-option>
            </el-select>
          </el-form-item>
          <el-form-item
            class="property-form__description__sectional-type"
            v-if="isSectional === '1'"
            label="Sectional Type"
          >
            <el-select
              v-model="property.sectionalTypes"
              placeholder="Sectional Type"
            >
              <el-option
                v-for="item in DATA.sectionalTypes"
                :label="item.label"
                :value="item.value"
                :key="item.value"
              ></el-option>
            </el-select>
          </el-form-item>
          <el-form-item
            class="property-form__description__price"
            :label="property.sale === '1' ? 'Price' : 'Rent'"
          >
            <el-row>
              <el-col :sm="11">
                <el-select v-model="property.sale">
                  <el-option label="For Rent" value="0"></el-option>
                  <el-option label="For Sale" value="1"></el-option>
                </el-select>
              </el-col>

              <el-col :sm="11">
                <el-input type="number" v-model="property.price">
                  <template #prepend>R</template>
                  <template #append v-if="!Number(property.sale)">p/m</template>
                </el-input>
              </el-col>
            </el-row>
          </el-form-item>
          <el-form-item
            class="property-form__description__text"
            label="Description"
          >
            <el-input v-model="property.description" type="textarea"></el-input>
          </el-form-item>
          <el-form-item
            class="property-form__description__images"
            label="Property Cover Image"
          >
            <el-upload
              action="#"
              list-type="picture-card"
              :auto-upload="false"
              accept="image/*"
              ref="uploadedCoverImage"
              :on-change="handleOnChange"
            >
              <template #default v-if="!property.cover_image">
                <i class="el-icon-plus"></i>
              </template>
              <template #default v-else>
                <i class="el-icon-edit"></i>
              </template>
              <template #file="{ file }">
                <div class="upload-thumbnail-container">
                  <img
                    class="el-upload-list__item-thumbnail"
                    :src="file.url"
                    alt=""
                  />
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
                      @click="handleRemove"
                    >
                      <i class="el-icon-delete"></i>
                    </span>
                  </span>
                </div>
              </template>
            </el-upload>
            <el-dialog v-model="dialogVisible">
              <img
                style="width: 100%; height: auto"
                :src="dialogImageUrl"
                alt=""
              />
            </el-dialog>
          </el-form-item>
        </el-collapse-item>
        <el-collapse-item
          class="property-form__address"
          title="Address"
          name="address"
        >
          <el-form-item
            class="property-form__address__unit"
            v-if="isSectional"
            label="Unit"
          >
            <el-input v-model="property.unit"></el-input>
          </el-form-item>
          <el-form-item class="property-form__address__street" label="Street">
            <el-input v-model="property.street"></el-input>
          </el-form-item>
          <el-form-item class="property-form__address__city" label="City">
            <el-input v-model="property.city"></el-input>
          </el-form-item>
          <el-form-item
            class="property-form__address__province"
            label="Province"
          >
            <el-select v-model="property.province" placeholder="Select">
              <el-option
                v-for="item in DATA.provinces"
                :key="item"
                :label="item"
                :value="item"
              >
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item
            class="property-form__address__code"
            label="Postal Code"
          >
            <el-input v-model="property.postal_code"></el-input>
          </el-form-item>
        </el-collapse-item>
        <el-collapse-item
          class="property-form__features"
          title="Features"
          name="features"
        >
          <el-form-item label="Property Images">
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
                  <img
                    class="el-upload-list__item-thumbnail"
                    :src="file.url"
                    alt=""
                  />
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
          </el-form-item>
        </el-collapse-item>
      </el-collapse>
      <div class="form-buttons">
        <el-button type="primary" @click="onSubmit">Create Property</el-button>
      </div>
    </el-form>
  </el-container>
</template>
<script lang="ts">
import { ElFile } from "@/interfaces";
import { defineComponent, onMounted, ref } from "vue";
import { manageNewProperty, DATA } from "@/composables/manageNewProperty";
import PropertyService from "@/services/PropertyService";
import { capitalize, titleCase } from "@/Helpers";
import displayWidth from "@/Helpers/GetScreenWidth";
import { ElNotification } from "element-plus";
import GetError, { ResponseError } from "@/Helpers/GetError";
interface IFeature {
  id: number;
  feature: string;
}
export default defineComponent({
  setup() {
    const activeFormItem = ref(["type"]);
    const {
      uploadedImages,
      uploadedCoverImage,
      onSubmit,
      property,
      isSectional,
      addFeature,
      removeFeature,
      newFeature,
    } = manageNewProperty();
    const dialogImageUrl = ref("");
    const dialogVisible = ref(false);
    const disabled = ref(false);
    const features = ref<IFeature[]>([]);
    const creatingFeature = ref(false);

    function setFeatures() {
      PropertyService.getFeatures().then((response) => {
        features.value = response.data.data;
      });
    }

    function handleCreateNewFeature() {
      creatingFeature.value = true;
      PropertyService.createFeature(newFeature.value.toLowerCase())
        .then(() => {
          setFeatures();
          newFeature.value = "";
          creatingFeature.value = false;
        })
        .catch((error) => {
          GetError(error as ResponseError).feature.forEach(
            (featureError: string) => {
              ElNotification({
                message: featureError,
                type: "error",
              });
            }
          );
          newFeature.value = "";
          creatingFeature.value = false;
        });
    }

    onMounted(() => {
      setFeatures();
    });
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
    function handleOnChange() {
      if (uploadedCoverImage.value) {
        if (uploadedCoverImage.value.uploadFiles.length > 1) {
          const currentImage = uploadedCoverImage.value.uploadFiles[1];
          uploadedCoverImage.value.clearFiles();
          uploadedCoverImage.value.uploadFiles = [currentImage];
        }
      }
    }
    function handleRemove() {
      if (uploadedCoverImage.value) {
        uploadedCoverImage.value.uploadFiles = [];
      }
    }
    return {
      DATA,
      uploadedCoverImage,
      uploadedImages,
      isSectional,
      property,
      activeFormItem,
      dialogImageUrl,
      dialogVisible,
      disabled,
      handleOnChange,
      handleRemove,
      handleRemoveMulti,
      handlePictureCardPreview,
      onSubmit,
      addFeature,
      features,
      titleCase,
      removeFeature,
      displayWidth,
      newFeature,
      handleCreateNewFeature,
      creatingFeature,
    };
  },
});
</script>

<style lang="scss" scoped>
.upload-thumbnail-container {
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  .el-upload-list__item-thumbnail {
    width: 80%;
    height: fit-content;
  }
}
.el-form-item {
  padding: 0 2rem;
}
.el-row {
  justify-content: space-between;
}
.el-select {
  width: 100%;
}
.property-form {
  &__features {
    &__list {
      display: flex;
      flex-flow: column nowrap;
      align-items: center;
      &__inputs {
        display: flex;
        flex-flow: column nowrap;
        align-items: center;
        padding: 0;
        @media (min-width: 767px) {
          display: flex;
          flex-flow: row nowrap;
          width: 100%;
        }
        &__feature {
          @media (min-width: 767px) {
            width: 50%;
            padding-right: 1rem;
            margin: 0;
          }
          display: flex;
          flex-flow: row nowrap;
          margin-bottom: 1rem;
          .el-select {
            margin-right: 0.5rem;
          }
        }
        &__value {
          width: 100%;
          padding: 0;
          margin-bottom: 1rem;
          @media (min-width: 767px) {
            width: 50%;
            margin: 0;
          }
        }
        &__add {
          margin-top: 1rem;
          @media (min-width: 767px) {
            margin: 0;
          }
        }
      }
    }
  }
}
.el-container {
  flex-flow: row nowrap;
  justify-content: center;
  .property-form {
    width: 100vw;
    box-shadow: 1px 1px 10px 0px #e6a23c, -1px -1px 10px 0px #e6a23c;
    .form-buttons {
      width: 100%;
      display: flex;
      flex-flow: row nowrap;
      justify-content: center;
      padding: 0;
      margin-top: 1rem;
    }
    padding: 1rem;
    @media (min-width: 767px) {
      padding: 2rem;
      // width: 80%;
    }
    @media (min-width: 1023px) {
      // width: 60%;
      margin-top: 5vh;
    }
  }
}
</style>

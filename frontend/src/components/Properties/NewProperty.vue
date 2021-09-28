<template>
  <div class="property">
    <el-form label-position="top">
      <div class="property__heading property-item">
        <el-form-item label="Title">
          <el-input v-model="propertyTitle" />
        </el-form-item>
        <el-form-item label="Cover Image">
          <single-image-upload @onImageChange="handleCoverImageChange" />
        </el-form-item>
      </div>
      <div class="property__images property-item">
        <el-form-item label="Image List">
          <multi-image-upload @uploadedImagesChange="handleImageListChange" />
        </el-form-item>
      </div>
      <div class="property__description property-item">
        <property-description-form
          @descriptionFormChange="handleDescriptionFormChange"
        />
      </div>
      <div class="property__features property-item">
        <el-form-item label="Features">
          <property-feature-list />
        </el-form-item>
      </div>
      <div class="property__agents property-item">
        <agents @agentListChange="handleAgentListChange" />
      </div>
      <el-form-item>
        <el-button>Create Property</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, reactive, ref } from "vue";
import GetScreenWidth from "@/Helpers/GetScreenWidth";
import { NewProperty } from "@/composables/Properties/NewProperty";
import SingleImageUpload from "@/components/Properties/NewProperty/SingleImageUpload.vue";
import PropertyFeatureList from "./NewProperty/PropertyFeatures/PropertyFeatureList.vue";
import PropertyDescriptionForm from "./NewProperty/PropertyDescriptionForm.vue";
import { titleCase } from "@/Helpers";
import MultiImageUpload from "./NewProperty/MultiImageUpload.vue";
import { IAgent } from "@/interfaces/Property";
import { List } from "@/interfaces";
import PropertyService from "@/services/PropertyService";
import GetError, { ResponseError } from "@/Helpers/GetError";
import Agents from "./NewProperty/Agents.vue";
import { IPropertyDescriptionForm } from "@/interfaces/Forms";
import { UploadFile } from "element-plus/lib/components/upload/src/upload.type";

const currencyFormatter = new Intl.NumberFormat("en-ZA", {
  currency: "ZAR",
  style: "currency",
});

export default defineComponent({
  components: {
    SingleImageUpload,
    PropertyDescriptionForm,
    PropertyFeatureList,
    MultiImageUpload,
    Agents,
  },
  methods: {
    titleCase,
  },
  setup() {
    const { property } = NewProperty();
    const propertyTitle = ref("");
    const agents = reactive<List<IAgent>>({ list: [] });
    const selectedAgents = reactive<List<number>>({ list: [] });

    onMounted(async () => {
      try {
        const { data: responseData } = await PropertyService.getAgents();
        agents.list = responseData.data;
      } catch (e) {
        GetError(e as ResponseError);
      }
    });
    const editing = ref(true);
    function handleCoverImageChange(image: UploadFile) {
      console.log(image);
    }
    function handleAgentListChange(list: number[]) {
      console.log(list);
    }
    function handleImageListChange(list: UploadFile[]) {
      console.log("Image List: ", list);
    }
    function handleDescriptionFormChange(
      propertyDescription: IPropertyDescriptionForm
    ) {
      console.log("Property: ", propertyDescription);
    }
    return {
      currencyFormatter,
      GetScreenWidth,
      property,
      editing,
      handleCoverImageChange,
      handleAgentListChange,
      handleImageListChange,
      handleDescriptionFormChange,
      agents,
      selectedAgents,
      propertyTitle,
    };
  },
});
</script>

<style lang="scss" scoped>
.property-item {
  border: 0.5px solid rgba($color: #888, $alpha: 0.5);
  margin-bottom: 2rem;
  padding: 1.75rem;
}

.property {
  height: fit-content;
  flex: 2;
  &__agents {
    &__item {
      &__details {
      }
    }
  }
  &__heading {
  }
  &__description {
  }
  &__images {
    &__image {
    }
  }
}
</style>

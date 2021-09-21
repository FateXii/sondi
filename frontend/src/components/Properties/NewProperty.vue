<template>
  <div class="property">
    <el-form label-position="top">
      <div class="property__heading">
        <el-form-item label="Title">
          <el-input />
        </el-form-item>
        <el-form-item label="Cover Image">
          <single-image-upload @onImageChange="handleCoverImageChange" />
        </el-form-item>
      </div>
      <div class="property__images property-item">
        <!-- <carousel /> -->
      </div>
      <div class="property__description property-item">
        <property-description-form />
      </div>
      <div class="property__features property-item">
        <el-form-item label="Features">
          <property-feature-list />
        </el-form-item>
      </div>
      <div class="property__agents property-item">
        <el-form-item> </el-form-item>
      </div>
    </el-form>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import GetScreenWidth from "@/Helpers/GetScreenWidth";
import { NewProperty } from "@/composables/Properties/NewProperty";
import SingleImageUpload from "@/components/Properties/NewProperty/SingleImageUpload.vue";
import PropertyFeatureList from "./NewProperty/PropertyFeatures/PropertyFeatureList.vue";
import PropertyDescriptionForm from "./NewProperty/PropertyDescriptionForm.vue";
import { titleCase } from "@/Helpers";

const currencyFormatter = new Intl.NumberFormat("en-ZA", {
  currency: "ZAR",
  style: "currency",
});

export default defineComponent({
  components: {
    SingleImageUpload,
    PropertyDescriptionForm,
    PropertyFeatureList,
  },
  setup() {
    const { property } = NewProperty();
    const editing = ref(true);
    function handleCoverImageChange(image: any) {
      console.log(image);
    }

    return {
      currencyFormatter,
      GetScreenWidth,
      property,
      editing,
      handleCoverImageChange,
      titleCase,
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

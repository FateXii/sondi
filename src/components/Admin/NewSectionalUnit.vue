<template lang="html">
  <el-scroll-bar max-height="400px">
    <el-form v-model="propertyForm" label-position="top">
      <el-form-item label="Unit">
        <el-input v-model="sectionalUnit" autocomplete="off"></el-input>
      </el-form-item>
      <el-form-item label="Description">
        <el-input v-model="propertyForm.description" type="textarea"></el-input>
      </el-form-item>
      <el-form-item label="Bedrooms">
        <el-input-number v-model="propertyForm.bedrooms"></el-input-number>
      </el-form-item>
      <el-form-item label="Bathrooms">
        <el-input-number v-model="propertyForm.bathrooms"></el-input-number>
      </el-form-item>
      <el-form-item label="Garages">
        <el-input-number v-model="propertyForm.garages"></el-input-number>
      </el-form-item>
      <el-form-item label="For Sale">
        <el-checkbox v-model="isForSale">For Sale</el-checkbox>
      </el-form-item>
      <el-form-item label="Price">
        <el-input placeholder="0.00" v-model="price">
          <template #prepend>R</template>
          <template #append v-if="!isForSale">p/m</template>
        </el-input>
      </el-form-item>
      <el-form-item label="Images">
        <input
          type="file"
          multiple
          accept="image/*"
          @change="setPropertyImages"
        />
      </el-form-item>
      <el-form-item>
        <el-button @click="createProperty">Create Property</el-button>
      </el-form-item>
    </el-form>
  </el-scroll-bar>
</template>

<script lang="ts">
import { defineComponent, PropType, reactive, ref } from "vue";
import { newSectionalPropertyUnit } from "@/composables/newSectionalPropertyUnit";
import { ISectionalPropertyModel } from "@/interfaces/apiTypes";

export default defineComponent({
  props: {
    sectional: {
      type: Object as PropType<ISectionalPropertyModel>,
    },
  },
  setup(prop) {
    const {
      createSectionalPropertyUnit,
      isForSale,
      price,
      setPropertyImages,
      propertyForm,
      sectionalUnit,
    } = newSectionalPropertyUnit();
    const createProperty = () => {
      if (prop.sectional) {
        createSectionalPropertyUnit(prop.sectional);
      } else {
        createSectionalPropertyUnit();
      }
    };

    return {
      isForSale,
      createProperty,
      price,
      setPropertyImages,
      propertyForm,
      sectionalUnit,
    };
  },
});
</script>

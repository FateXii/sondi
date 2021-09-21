<template>
  <div class="property__description__title">
    <el-form-item label="Description Title">
      <el-input />
    </el-form-item>
  </div>
  <div class="property__decription__price">
    <el-form-item label="Price">
      <el-input />
    </el-form-item>
  </div>
  <div class="property__decription_address">
    <el-form-item label="Address">
      <property-address />
    </el-form-item>
  </div>
  <h3 class="property__description__heading">
    <el-form-item label="Description Heading">
      <el-input />
    </el-form-item>
  </h3>
  <div class="property__description__text">
    <el-form-item label="Description">
      <el-input type="textarea" />
    </el-form-item>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import PropertyAddress from "@/components/Properties/NewProperty/PropertyAddress.vue";

export default defineComponent({
  components: {
    PropertyAddress,
  },
  setup() {
    return {};
  },
});
</script>

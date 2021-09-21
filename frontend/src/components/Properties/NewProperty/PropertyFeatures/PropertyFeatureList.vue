<template>
  <property-feature
    v-for="index in propertyFeatures.length"
    :key="index"
    v-model:feature="propertyFeatures[index - 1]"
    :features="features"
    :index="index"
  />
  <el-button icon="el-icon-plus" @click="newPropertyFeature()" />
</template>

<script lang="ts">
import { ICurrentFeature, IPropertyFeature } from "@/interfaces/Property";
import PropertyService from "@/services/PropertyService";
import { defineComponent, nextTick, onMounted, reactive, ref } from "vue";
import PropertyFeature from "@/components/Properties/NewProperty/PropertyFeatures/PropertyFeature.vue";

export default defineComponent({
  components: { PropertyFeature },
  setup() {
    const features = ref<IPropertyFeature[]>([]);
    const propertyFeatures = reactive<ICurrentFeature[]>([]);
    onMounted(() => {
      nextTick(() => {
        PropertyService.getFeatures().then((response) => {
          features.value = response.data.data;
        });
      });
    });
    function emptyPropertyFeature() {
      return { id: 0, value: "" };
    }
    function newPropertyFeature() {
      propertyFeatures.push(emptyPropertyFeature());
    }
    return {
      newPropertyFeature,
      propertyFeatures,
      features,
    };
  },
});
</script>

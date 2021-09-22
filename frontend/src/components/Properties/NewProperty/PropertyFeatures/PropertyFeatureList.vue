<template>
  <property-feature
    v-for="(value, index) in propertyFeatures.list"
    :key="index"
    v-model:feature="propertyFeatures.list[index]"
    :features="features"
  />
  <el-button icon="el-icon-refresh" @click="refreshFeatureSelection" />
  <el-button icon="el-icon-plus" @click="newPropertyFeature()" />
</template>

<script lang="ts">
import { ICurrentFeature, IPropertyFeature } from "@/interfaces/Property";
import PropertyService from "@/services/PropertyService";
import {
  defineComponent,
  onMounted,
  reactive,
  ref,
  watch,
  watchEffect,
} from "vue";
import PropertyFeature from "@/components/Properties/NewProperty/PropertyFeatures/PropertyFeature.vue";

export default defineComponent({
  components: { PropertyFeature },
  setup() {
    const features = ref<IPropertyFeature[]>([]);
    const propertyFeatures = reactive<{ list: ICurrentFeature[] }>({
      list: [],
    });
    const selectedFeatures = ref<number[]>([]);
    onMounted(() => {
      PropertyService.getFeatures().then((response) => {
        features.value = response.data.data;
      });
    });
    watch(propertyFeatures, () => {
      selectedFeatures.value = propertyFeatures.list.map(
        (propFeat) => propFeat.id
      );
    });
    function emptyPropertyFeature() {
      const feat =
        features.value.find(
          (feature) => !selectedFeatures.value.includes(feature.id)
        ) || features.value[0];
      const id = feat.id;
      let value = "";
      if (feat.type == "boolean") {
        value = "no";
      } else if (feat.type == "number") {
        value = "1";
      }
      return { id, value, type: feat.type };
    }
    function newPropertyFeature() {
      propertyFeatures.list.push(emptyPropertyFeature());
    }
    function refreshFeatureSelection() {
      propertyFeatures.list = [];
    }
    return {
      newPropertyFeature,
      refreshFeatureSelection,
      propertyFeatures,
      features,
    };
  },
});
</script>

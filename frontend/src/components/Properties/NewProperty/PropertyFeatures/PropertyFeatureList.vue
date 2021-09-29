<template>
  <div class="property-feature-list">
    <el-alert
      title="Duplicate Features"
      type="error"
      description="Two features cannot be of the same type"
      closable
      @close="() => (duplicateFeature = false)"
      v-if="duplicateFeature"
    >
    </el-alert>
    <div
      class="property-feature-list__item"
      v-for="(feature, index) in propertyFeatures.list"
      :key="index"
    >
      <span>
        {{ `${titleCase(feature.name)} ${feature.value}` }}
      </span>
      <el-button
        icon="el-icon-delete"
        type="danger"
        @click="deleteFeature(index)"
      />
    </div>
  </div>
  <property-feature @addFeature="handleNewFeature" />
  <el-button icon="el-icon-refresh" @click="refreshFeatureSelection" />
  <el-button icon="el-icon-plus" @click="newPropertyFeature()" />
</template>

<script lang="ts">
import { ICurrentFeature, IPropertyFeature } from "@/Types/Property";
import PropertyService from "@/services/PropertyService";
import { defineComponent, onMounted, reactive, ref, watch } from "vue";
import PropertyFeature from "@/components/Properties/NewProperty/PropertyFeatures/PropertyFeature.vue";
import { titleCase } from "@/Helpers";

export default defineComponent({
  components: { PropertyFeature },
  methods: { titleCase },
  emits: {
    newFeatures: (list: IPropertyFeature[]) => (list && true) || false,
  },
  setup(_, { emit }) {
    const features = ref<IPropertyFeature[]>([]);
    const duplicateFeature = ref(false);
    const propertyFeatures = reactive<{ list: IPropertyFeature[] }>({
      list: [],
    });
    onMounted(() => {
      PropertyService.getFeatures().then((response) => {
        features.value = response.data.data;
      });
    });
    watch(propertyFeatures, ({ list: newFeatures }) => {
      emit("newFeatures", newFeatures);
    });

    function handleNewFeature(feature: ICurrentFeature) {
      const currentFeature = features.value.find(
        (serchFeature) => serchFeature.id === feature.id
      );
      if (
        propertyFeatures.list.find(
          (searchFeature) => searchFeature.id === feature.id
        )
      ) {
        duplicateFeature.value = true;
        return;
      }
      feature &&
        propertyFeatures.list.push({
          name: (currentFeature && currentFeature.name) || "",
          ...feature,
        });
    }
    function refreshFeatureSelection() {
      propertyFeatures.list = [];
    }
    function deleteFeature(index: number) {
      propertyFeatures.list.splice(index, 1);
    }
    return {
      handleNewFeature,
      refreshFeatureSelection,
      deleteFeature,
      propertyFeatures,
      features,
      duplicateFeature,
    };
  },
});
</script>

<style lang="scss" scoped>
.property-feature-list {
  margin-bottom: 1rem;
  &__item {
    margin-bottom: 0.125rem;
    display: flex;
    flex-flow: row nowrap;
    justify-content: space-between;
  }
}
</style>

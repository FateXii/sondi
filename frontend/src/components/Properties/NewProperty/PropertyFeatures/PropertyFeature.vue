<template>
  <div class="property-feature-input">
    <el-select
      v-model="currentFeatureId"
      class="property-feature-input__feature-select"
      filterable
    >
      <el-option
        v-for="feature in features.list"
        :key="feature.id"
        :value="feature.id"
        :label="titleCase(feature.name)"
      >
        <span>{{ titleCase(feature.name) }}</span> &nbsp;
        <span style="float: right; color: lightgrey"
          >| &nbsp; {{ feature.type }}</span
        >
      </el-option>
      <template #empty>
        <el-button
          style="width: 100%; height: 100%"
          @click="newPropertyFeatureDialog = true"
          >Create New</el-button
        >
        <new-property-feature v-model="newPropertyFeatureDialog" />
      </template>
    </el-select>
    <div class="property-feature-input__value-input">
      <el-input
        class="property-feature-input__value-input__field"
        v-model="featureValue"
        v-if="featureType === 'string'"
      />
      <el-input
        class="property-feature-input__value-input__field"
        type="number"
        v-model="featureValue"
        v-else-if="featureType === 'number'"
        min="1"
        placeholder="1"
      />
      <el-checkbox-button
        class="property-feature-input__value-input__field"
        v-model="featureValue"
        true-label="yes"
        false-label="no"
        v-else-if="featureType === 'boolean'"
      >
        {{ featureValue === "yes" ? "Yes" : "No" }}
      </el-checkbox-button>
    </div>
    <el-button icon="el-icon-document-add" @click="addFeature" />
  </div>
</template>
<script lang="ts">
import { titleCase } from "@/Helpers";
import GetError, { ResponseError } from "@/Helpers/GetError";
import { ICurrentFeature, IPropertyFeature } from "@/Types/Property";
import PropertyService from "@/services/PropertyService";
import {
  defineComponent,
  nextTick,
  onMounted,
  reactive,
  ref,
  watch,
} from "vue";
import { Feature } from "@/Types/Feature";
import { List } from "@/Types";
import NewPropertyFeature from "./NewPropertyFeature.vue";

export default defineComponent({
  components: { NewPropertyFeature },
  emits: {
    addFeature: (feature: ICurrentFeature) => {
      if (feature) {
        return feature.id && feature.value && feature.type;
      } else {
        console.error("PropertyFeature-(Emit AddFeature): Feature Undefined");
      }
    },
  },
  setup(_, { emit }) {
    const features = reactive<List<IPropertyFeature>>({ list: [] });
    const currentFeatureId = ref(1);
    const featureValue = ref<string>("");
    const featureType = ref("number");
    const currentFeature = reactive<ICurrentFeature>({
      id: 0,
      ...new Feature(),
    });
    const newPropertyFeatureDialog = ref(false);
    onMounted(async () => {
      try {
        const response = await PropertyService.getFeatures();
        features.list = response.data.data;
        currentFeatureId.value = features.list[0].id;
        featureType.value = features.list[0].type;
        if (featureType.value === "number") {
          featureValue.value = "1";
        } else if (featureType.value === "boolean") {
          featureValue.value = "no";
        } else {
          featureValue.value = "";
        }
      } catch (e) {
        GetError(e as ResponseError);
      }
      await nextTick();
    });
    watch(currentFeatureId, (newFeature) => {
      const feature = features.list.find(
        (feature) => feature.id === newFeature
      );
      featureType.value = feature?.type || "string";
      Object.assign(currentFeature, {
        id: feature?.id,
        value: featureValue,
        type: feature?.type,
      });
    });
    function addFeature() {
      emit("addFeature", currentFeature);
    }

    return {
      currentFeatureId,
      featureValue,
      featureType,
      features,
      newPropertyFeatureDialog,
      addFeature,
      titleCase,
    };
  },
});
</script>

<style lang="scss" scoped>
.property-feature-input {
  display: flex;
  flex-flow: row nowrap;
  margin-bottom: 1rem;
  &__feature-select {
    flex: 3;
  }
  &__value-input {
    flex: 1;
    &__field {
    }
  }
}
</style>

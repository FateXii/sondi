<template>
  <div class="property-feature-input">
    <el-form label-width="150px" label-position="left">
      <el-form-item
        v-for="feature in features.list"
        :label="titleCase(feature.name)"
        :key="feature.id"
      >
        <el-switch
          v-if="feature.type === 'boolean'"
          v-model="feature.value"
          active-value="yes"
          inactive-value="no"
        ></el-switch>
        <el-input v-else-if="feature.type === 'string'" v-model="feature.value">
        </el-input>
        <el-input v-else v-model="feature.value" type="number" min="1">
        </el-input>
      </el-form-item>
    </el-form>
    <el-button
      style="width: 100%; height: 100%"
      @click="newPropertyFeatureDialog = true"
      >Create New</el-button
    >
    <new-property-feature v-model="newPropertyFeatureDialog" />
  </div>
</template>
<script lang="ts">
import { titleCase } from "@/Helpers";
import GetError, { ResponseError } from "@/Helpers/GetError";
import { IPropertyFeature } from "@/Types/Property";
import PropertyService from "@/services/PropertyService";
import {
  defineComponent,
  nextTick,
  onMounted,
  reactive,
  ref,
  watch,
} from "vue";
import { List } from "@/Types";
import NewPropertyFeature from "./NewPropertyFeature.vue";

export default defineComponent({
  components: { NewPropertyFeature },
  emits: {
    newFeatures: (features: IPropertyFeature[]) => {
      return features !== undefined;
    },
  },
  setup(_, { emit }) {
    const features = reactive<List<IPropertyFeature>>({ list: [] });
    // const currentFeatureId = ref(-1);
    // const featureValue = ref<string>("");
    // const featureType = ref("number");
    // const currentFeature = reactive<ICurrentFeature>({
    //   id: 0,
    //   ...new Feature(),
    // });
    const newPropertyFeatureDialog = ref(false);
    onMounted(async () => {
      await nextTick();
      try {
        const response = await PropertyService.getFeatures();
        features.list = response.data.data;
        features.list.map((feature) => {
          if (feature.type === "number") {
            if (feature.value) feature.value = "1";
            else Object.assign(feature, { value: "0", ...feature });
          } else if (feature.type === "boolean") {
            if (feature.value) feature.value = "no";
          } else {
            if (feature.value) feature.value = "";
          }
        });
      } catch (e) {
        GetError(e as ResponseError);
      }
    });
    watch(features, () => {
      emit("newFeatures", features.list);
    });

    return {
      features,
      newPropertyFeatureDialog,
      titleCase,
    };
  },
});
</script>

<style lang="scss" scoped>
.property-feature-input {
  display: flex;
  flex-flow: column nowrap;
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

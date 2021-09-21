<template>
  <div class="property-feature-input">
    <el-select-v2
      v-model="selectedFeature"
      class="property-feature-input__feature-select"
      :options="options"
      filterable
    >
      <template #default="{ item }">
        <span>{{ item.label }}</span> | <span>{{ item.type }}</span>
      </template>
      <template #empty>
        <el-button style="width: 100%">Create New</el-button>
      </template>
    </el-select-v2>
    <div class="property-feature-input__value-input">
      <el-input
        class="property-feature-input__value-input__field"
        v-model="featureValue"
        v-if="currentFeature && currentFeature.type === 'string'"
      />
      <el-input
        class="property-feature-input__value-input__field"
        type="number"
        v-model="featureValue"
        v-else-if="currentFeature && currentFeature.type === 'number'"
        min="1"
        placeholder="1"
      />
      <el-checkbox-button
        class="property-feature-input__value-input__field"
        v-model="featureValue"
        true-label="yes"
        false-label="no"
        :checked="false"
        v-else-if="currentFeature && currentFeature.type === 'boolean'"
      >
        {{ featureValue === "yes" ? "Yes" : "No" }}
      </el-checkbox-button>
    </div>
  </div>
</template>
<script lang="ts">
import { titleCase } from "@/Helpers";
import { ICurrentFeature, IPropertyFeature } from "@/interfaces/Property";
import {
  defineComponent,
  nextTick,
  onMounted,
  PropType,
  ref,
  toRefs,
  watch,
  watchEffect,
} from "vue";

export default defineComponent({
  props: {
    feature: {
      type: Object as PropType<ICurrentFeature>,
      required: true,
    },
    features: {
      type: Object as PropType<IPropertyFeature[]>,
      required: true,
    },
    index: {
      type: Number,
      required: true,
    },
  },
  emits: {
    "update:feature": null,
  },
  setup(props, { emit }) {
    const { features, index } = toRefs(props);
    const options = ref<{ value: number; label: string; type: string }[]>([]);
    watchEffect(() => {
      options.value = features.value.map((feature) => ({
        value: feature.id,
        label: titleCase(feature.name),
        type: feature.type,
      }));
    });
    const selectedFeature = ref(1);
    const currentFeature = ref<IPropertyFeature>();
    const featureValue = ref<string>("");
    onMounted(() => {
      nextTick(() => {
        selectedFeature.value = features.value && features.value[0].id;
      });
    });
    watch(selectedFeature, (id) => {
      currentFeature.value = features.value.find(
        (feature) => feature.id === id
      );
    });
    watch([selectedFeature, featureValue], ([id, value]) => {
      emit("update:feature", {
        id: id,
        value: value,
      });
    });

    return {
      selectedFeature,
      currentFeature,
      featureValue,
      options,
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

<template>
  <div class="property-feature-input">
    <el-select
      v-model="currentFeature.id"
      class="property-feature-input__feature-select"
      filterable
    >
      <el-option
        v-for="feature in features"
        :key="feature.id"
        :value="feature.id"
        :label="feature.name"
      >
        <span>{{ feature.name }}</span> | <span>{{ feature.type }}</span>
        <template #empty>
          <el-button style="width: 100%">Create New</el-button>
        </template>
      </el-option>
    </el-select>
    <div class="property-feature-input__value-input">
      <el-input
        class="property-feature-input__value-input__field"
        v-model="currentFeature.value"
        v-if="currentFeature && currentFeature.type === 'string'"
      />
      <el-input
        class="property-feature-input__value-input__field"
        type="number"
        v-model="currentFeature.value"
        v-else-if="currentFeature && currentFeature.type === 'number'"
        min="1"
        placeholder="1"
      />
      <el-checkbox-button
        class="property-feature-input__value-input__field"
        v-model="currentFeature.value"
        true-label="yes"
        false-label="no"
        v-else-if="currentFeature && currentFeature.type === 'boolean'"
      >
        {{ currentFeature.value === "yes" ? "Yes" : "No" }}
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
  reactive,
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
  },
  emits: {
    "update:feature": null,
  },
  setup(props, { emit }) {
    const { features, feature } = toRefs(props);
    const currentFeature = reactive<ICurrentFeature>(feature.value);
    const featureValue = ref<string>("");

    onMounted(async () => {
      await nextTick();
      await nextTick();
      Object.assign(currentFeature, feature.value);
    });
    watch(currentFeature, (newFeature) => {
      const { id } = newFeature;
      Object.assign(
        currentFeature,
        features.value.find((feature) => feature.id === id)
      );
      const { value, type } = currentFeature;
      emit("update:feature", {
        id,
        value,
        type,
      });
    });

    return {
      currentFeature,
      featureValue,
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

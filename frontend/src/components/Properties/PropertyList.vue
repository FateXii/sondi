<template>
  <el-container class="property-list">
    <el-skeleton
      style="width: 50rem"
      :loading="loadingProperties"
      animated
      count="3"
    >
      <template #template>
        <el-skeleton-item variant="image" style="width: 50rem; height: 50rem" />
        <div style="padding: 14px">
          <el-skeleton-item variant="h3" style="width: 40%" />
          <div
            style="
              display: flex;
              align-items: center;
              flex-flow: column;
              justify-items: space-between;
              margin-top: 16px;
              height: 16px;
            "
          >
            <el-skeleton-item variant="text" />
            <el-skeleton-item variant="text" />
            <el-skeleton-item variant="text" />
          </div>
        </div>
      </template>
      <template #default v-if="properties">
        <div
          class="property-list__item-container"
          v-for="property in properties.slice(0, 5)"
          :key="property.id"
        >
          <property-item :property="property" />
        </div>
      </template>
    </el-skeleton>
  </el-container>
</template>

<script lang="ts">
import { defineComponent, onMounted, ref } from "vue";
import PropertyService from "@/services/PropertyService";
import { IProperty } from "@/interfaces/Property";
import GetError, { ResponseError } from "@/Helpers/GetError";
import PropertyItem from "./PropertyItem.vue";
const currencyFormatter = new Intl.NumberFormat("en-ZA", {
  currency: "ZAR",
  style: "currency",
});
export default defineComponent({
  components: { PropertyItem },
  setup() {
    const loadingProperties = ref(false);
    const properties = ref<IProperty[]>();
    function loadProperties() {
      loadingProperties.value = true;
      PropertyService.getAll()
        .then((res) => {
          const { data } = res;
          properties.value = data.data;
          loadingProperties.value = false;
        })
        .catch((e) => GetError(e as ResponseError));
    }
    onMounted(() => {
      loadProperties();
    });
    return {
      loadingProperties,
      loadProperties,
      properties,
      currencyFormatter,
    };
  },
});
</script>

<style lang="scss" scoped>
.property-list {
  display: flex;
  flex-flow: column nowrap;
  align-items: center;
  &__item-container {
    max-width: 950px;
  }
}
</style>

<template>
  <el-container
    class="property-list"
    v-if="properties && properties.length > 0"
    v-loading="loadingProperties"
  >
    <div
      class="property-list__item-container"
      v-for="property in properties.slice(0, 5)"
      :key="property.id"
    >
      <property-item :property="property" />
    </div>
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

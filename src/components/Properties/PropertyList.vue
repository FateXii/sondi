<template>
  <el-container class="property-list" v-if="properties">
    <div
      class="property-list__item-container"
      v-for="property in properties"
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
        .catch((e) => console.log(e));
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
}
</style>

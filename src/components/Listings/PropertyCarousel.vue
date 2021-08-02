<template lang="html">
  <div class="property-carousel">
    <el-carousel
      height="22.5rem"
      arrow="always"
      :autoplay="false"
      ref="currentlyViewing"
      v-if="properties"
    >
      <el-carousel-item
        v-for="property in properties"
        :key="property.property.id"
        :name="`${property.property.id}`"
      >
        <PropertyCard :property="property" />
      </el-carousel-item>
    </el-carousel>
    <h1 v-else>No properties to show</h1>
  </div>
</template>

<script lang="ts">
import { watchEffect, defineComponent, ref, computed, onMounted } from "vue";
import { ElCarousel } from "element-plus";
import PropertyCard from "@/components/PropertyCard.vue";
import { Property } from "@/interfaces";
import { manageProperties } from "@/composables/manageProperties";

export default defineComponent({
  components: {
    PropertyCard,
  },
  emits: ["currentlyViewing"],
  setup(_, { emit }) {
    const { propertiesForSale, propertiesForRent, isBuying } =
      manageProperties();
    const properties = ref<Property[]>([]);

    const currentlyViewing = ref<InstanceType<typeof ElCarousel>>();
    watchEffect(() => {
      if (isBuying.value) {
        console.log(propertiesForSale);
        properties.value = propertiesForSale.value;
      } else {
        console.log(propertiesForRent);
        properties.value = propertiesForRent.value;
      }
      const current = currentlyViewing.value;
      const items = current?.items;
      let activeItem = items?.find((item) => item.active);
      if (!activeItem) {
        if (items && items?.length > 0) {
          currentlyViewing.value?.setActiveItem(items[0].name);
          activeItem = items[0];
        }
      }
      if (activeItem) {
        emit(
          "currentlyViewing",
          properties.value.find(
            (property: Property) =>
              property.property.id === Number(activeItem?.name)
          )
        );
      }
    });
    return {
      currentlyViewing,
      properties,
    };
  },
});
</script>

<style scoped lang="scss">
.el-carousel {
  box-shadow: 4px 4px 11px #f5e18f;
  width: 20rem;
}
</style>

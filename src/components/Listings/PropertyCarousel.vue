<template lang="html">
  <div class="property-carousel">
    <el-carousel
      height="22.5rem"
      arrow="always"
      :autoplay="false"
      ref="currentlyViewing"
    >
      <el-carousel-item
        v-for="property in properties"
        :key="property.id"
        :name="`${property.id}`"
      >
        <PropertyCard :property="property" />
      </el-carousel-item>
    </el-carousel>
  </div>
</template>

<script lang="ts">
import { watchEffect, defineComponent, ref, computed } from "vue";
import { useStore } from "vuex";
import { ElCarousel } from "element-plus";
import PropertyCard from "@/components/PropertyCard.vue";
import { Property } from "@/interfaces";
export default defineComponent({
  components: {
    PropertyCard,
  },
  emits: ["currentlyViewing"],
  setup(_, { emit }) {
    const store = useStore();
    const properties = computed(() => store.state.list);
    const currentlyViewing = ref<InstanceType<typeof ElCarousel>>();
    watchEffect(() => {
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
            (property: Property) => property.id === Number(activeItem?.name)
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

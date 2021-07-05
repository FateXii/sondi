<template>
  <div class="property-carousel">
    <el-carousel
      height="22.5rem"
      arrow="always"
      :autoplay="false"
      ref="currentlyViewing"
    >
      <el-carousel-item
        v-for="property in properties()"
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
import PropertyCard from "./PropertyCard.vue";
import { Property } from "@/interfaces";
export default defineComponent({
  components: {
    PropertyCard,
  },
  emits: ["currentlyViewing"],
  setup(_, { emit }) {
    const store = useStore();
    const properties = computed(() => store.getters.getProperties);
    const currentlyViewing = ref<InstanceType<typeof ElCarousel>>();

    watchEffect(() => {
      const current = currentlyViewing.value;
      const items = current?.items;
      if (current?.data.activeIndex === -1) {
        if (items && items[0]) {
          currentlyViewing.value?.next();
        }
      }
      const currentActive = current?.items.find((card) => card.active);
      if (currentActive) {
        emit(
          "currentlyViewing",
          properties
            .value()
            .find(
              (property: Property) => property.id === Number(currentActive.name)
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

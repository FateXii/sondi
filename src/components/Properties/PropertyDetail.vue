<template>
  <div v-if="property" class="property">
    <h1 class="property__heading">
      <span class="property__heading__price">
        {{ formatter.format(property.price) }}
      </span>
      |
      <span class="property__heading__title">{{ property.title }}</span>
    </h1>
    <div class="property__images property-item">
      <el-carousel height="20rem" :interval="4000" type="card">
        <el-carousel-item v-for="image in property.images" :key="image">
          <img
            ref="propImage"
            class="property__images__image"
            :src="setImageHost(image)"
            srcset=""
          />
        </el-carousel-item>
      </el-carousel>
    </div>
    <div class="property__description property-item">
      <h1 class="property__description__heading"></h1>
      <p class="property__description__text">
        {{ property.description }}
      </p>
    </div>
  </div>
</template>

<script lang="ts">
import propertyApi from "@/services/property";
import { defineComponent, onMounted, ref, watch, watchEffect } from "vue";
import { useRoute, useRouter } from "vue-router";
import { ElCarousel } from "element-plus";

const formatter = new Intl.NumberFormat("en-ZA", {
  currency: "ZAR",
  style: "currency",
});

export default defineComponent({
  setup() {
    const property = ref();
    const route = useRoute();
    function setImageHost(image: string) {
      return `${process.env.VUE_APP_API_HOST}${image}`;
    }
    onMounted(() => {
      propertyApi.get(Number(route.params.id)).then((res) => {
        const { data } = res;
        property.value = data;
      });
    });
    return {
      property,
      formatter,
      setImageHost,
    };
  },
});
</script>

<style lang="scss" scoped>
.el-carousel {
  &__container {
    height: fit-content;
  }
  &__item {
    display: flex;
    flex-flow: row nowrap;
    justify-content: center;
    align-items: center;
    height: fit-content;
  }
}

.property-item {
  border: 0.5px solid #444;
  padding: 2rem;
  margin-bottom: 2rem;
}
.property {
  &__images {
    &__image {
      max-height: 20rem;
    }
  }
}
</style>

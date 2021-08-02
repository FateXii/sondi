<template lang="html">
  <div class="card">
    <el-card shadow="never" :body-style="{ padding: '0px' }">
      <img :src="setImageHost(imagePath)" class="card__image" />
      <div class="card__description">
        <span class="card__description__price">R {{ property.price }} </span>
        <div class="card__description__stats" v-if="property.bedrooms > 0">
          <div class="card__description__stats__container">
            <span class="card__description__stats__container__number">{{
              property.bedrooms
            }}</span>
            <img
              :src="require('../assets/icons/bed.svg')"
              class="card__description__stats__container__icon"
              alt="location droppoint"
            />
          </div>
          <div
            class="card__description__stats__container"
            :v-if="property.bathrooms > 0"
          >
            <span class="card__description__stats__container__number">{{
              property.bathrooms
            }}</span>
            <img
              :src="require('../assets/icons/bath.svg')"
              class="card__description__stats__container__icon"
              alt="location droppoint"
            />
          </div>
          <div
            class="card__description__stats__container"
            :v-if="property.garages > 0"
          >
            <span class="card__description__stats__container__number">{{
              property.garages
            }}</span>
            <img
              :src="require('../assets/icons/gar.svg')"
              class="card__description__stats__container__icon"
              alt="location droppoint"
            />
          </div>
        </div>
      </div>
    </el-card>
  </div>
</template>

<script lang="ts">
import { defineComponent, PropType, ref, onMounted, watchEffect } from "vue";
import { Property } from "@/interfaces";
import propertyImageApi from "@/services/PropertyImage";
import { IImageModel } from "@/interfaces/apiTypes";

export default defineComponent({
  props: {
    property: {
      type: Object as PropType<Property>,
      required: true,
    },
  },
  setup(prop) {
    const setImageHost = (image: string) => {
      return `${process.env.VUE_APP_API_HOST}${image}`;
    };
    const propertyImage = ref<IImageModel>();
    const imagePath = ref("");
    watchEffect(() => {
      propertyImageApi.getAll(prop.property.property.id).then((response) => {
        const { data } = response;
        imagePath.value = data[0].path;
      });
    });
    return {
      setImageHost,
      propertyImage,
      imagePath,
    };
  },
});
</script>

<style lang="scss" scoped>
.card {
  width: 20rem;
  &__image {
    width: 100%;
  }
  &__description {
    display: flex;
    flex-flow: column nowrap;
    padding: 1rem;
    font-weight: 500;
    &__location {
      display: flex;
      flex-flow: row nowrap;
      align-items: center;
      padding: 0.5rem 0;
      &__icon {
        height: 1.25rem;
        width: 1.25rem;
      }
      &__text {
        color: #989898;
        font-size: 1rem;
      }
    }
    &__stats {
      display: flex;
      flex-flow: row nowrap;
      align-items: center;
      &__container {
        display: flex;
        flex-flow: row nowrap;
        align-items: center;
        padding: 0 1rem 0 0;
        &__number {
          font-size: 1.5rem;
          padding: 0 0.5rem 0 0;
        }
        &__icon {
          height: 2rem;
          width: 2rem;
        }
      }
    }
  }
}
</style>

<template lang="html">
  <div class="property-description" v-if="property && property !== undefined">
    <el-carousel
      class="property-description__images"
      :autoplay="false"
      trigger="click"
      indicator-position="none"
    >
      <el-carousel-item
        v-for="(image, index) in property.imageList.allImages"
        :key="index"
      >
        <div class="property-description__images__image">
          <img :src="require(`../assets/${image}`)" alt="image of house ____" />
        </div>
      </el-carousel-item>
    </el-carousel>
    <div class="property-description__details">
      <div class="property-description__details__specs">
        <span class="property-description__details__specs__price"
          >R {{ property.price }}
        </span>
        <span class="property-description__details__specs__name">{{
          property.name
        }}</span>
        <div class="property-description__details__specs__location">
          <img
            class="property-description__details__specs__location__icon"
            :src="require('../assets/icons/location.svg')"
            alt="location droppoint"
          />
          <span class="property-description__details__specs__location__text">{{
            property.location
          }}</span>
        </div>
      </div>
      <div class="property-description__details__text">
        <p>
          {{ property.description }}
        </p>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, PropType } from "vue";
import { Property } from "@/interfaces";
export default defineComponent({
  props: {
    showInterest: Boolean,
    property: {
      type: Object as PropType<Property>,
      required: true,
    },
  },
  setup() {
    return {};
  },
});
</script>
<style lang="scss">
div.properties
  > div
  > div.property-description
  > div.el-carousel.el-carousel--horizontal.property-description__images
  > div {
  @media (max-width: 320px) {
    height: 13rem;
  }
  @media (max-width: 375px) {
    height: 15rem;
  }
  @media (min-width: 767px) {
    height: 27rem;
  }
}
</style>

<style scoped lang="scss">
.el-carousel__container {
  @media (max-width: 320px) {
    height: 13rem;
  }
}
.property-description {
  display: flex;
  flex-flow: column nowrap;
  width: 40rem;
  margin: 3rem 0 0;
  @media (min-width: 991px) {
    margin: 0 0 0 2rem;
  }
  &__images {
    width: 100%;
    &__image {
      img {
        width: 100%;
      }
    }
  }
  &__details {
    display: flex;
    padding: 1rem;
    flex-flow: row nowrap;
    width: 100%;
    &__specs {
      display: flex;
      flex-flow: column nowrap;
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
    }
    &__text {
      p {
        overflow-wrap: break-word;
        margin: 0 1rem;
      }
    }
  }
}
</style>

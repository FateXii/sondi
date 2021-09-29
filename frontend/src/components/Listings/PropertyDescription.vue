<template lang="html">
  <div class="property-description" v-if="property && property !== undefined">
    <el-carousel
      class="property-description__images"
      :autoplay="false"
      trigger="click"
      indicator-position="none"
    >
      <el-carousel-item v-for="(image, index) in imagePath" :key="index">
        <div class="property-description__images__image">
          <img :src="setImageHost(image)" alt="image of house ____" />
        </div>
      </el-carousel-item>
    </el-carousel>
    <div class="property-description__details">
      <div class="property-description__details__specs">
        <span class="property-description__details__specs__price"
          >R {{ property.price }}
        </span>
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
import { defineComponent, onMounted, PropType, ref } from "vue";
import { Property } from "@/Types";
import propertyImageApi from "@/services/PropertyImage";
import { IImageModel } from "@/Types/apiTypes";
export default defineComponent({
  props: {
    showInterest: Boolean,
    property: {
      type: Object as PropType<Property>,
      required: true,
    },
  },
  setup(prop) {
    const setImageHost = (image: string) => {
      return `${process.env.VUE_APP_API_HOST}${image}`;
    };
    const imagePath = ref([]);
    onMounted(() => {
      propertyImageApi.getAll(prop.property.property.id).then((response) => {
        const { data } = response;
        imagePath.value = data.map(
          (image: IImageModel) => `storage/${image.path}`
        );
      });
    });
    return {
      setImageHost,
      imagePath,
    };
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

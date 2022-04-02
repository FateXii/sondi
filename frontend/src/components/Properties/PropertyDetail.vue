<template>
  <el-container v-loading="!property">
    <section class="property" v-if="property">
      <carousel :images="images" class="property__images-md" />
      <section :images="images" class="property__images">
        <el-image
          :src="currentImage"
          fit="contain"
          class="property__images__display"
        ></el-image>
      </section>
      <aside class="property__images__list">
        <div
          class="property__images__list__item"
          v-for="image in images.list"
          :key="image"
        >
          <el-image
            class="property__image-list__item__image"
            :src="image"
            @click="setCurrentImage(image)"
            fit="cover"
          ></el-image>
        </div>
      </aside>
      <section class="property__description">
        <header class="property__description__heading">
          <span class="property__description__heading__price">
            {{ getPrice(property.price) }}
          </span>
          <span class="property__description__heading__address">
            {{ titleCase(property.address.street) }},
            {{ titleCase(property.address.city) }}
          </span>
        </header>
        <main class="property__description__main">
          <section class="property__description__main__feature-list">
            <span
              class="property__description__main__feature-list__feature"
              v-for="feature in features"
              :key="feature.id"
            >
              <strong>
                {{ feature.value && titleCase(feature.name) }}
              </strong>
              {{
                feature.value &&
                `${
                  feature.value == "yes"
                    ? ""
                    : feature.type == "area"
                    ? " : " + feature.value + " m2"
                    : " : " + feature.value
                } `
              }}
            </span>
          </section>
          <section class="property__description__main__text">
            <strong>
              <span class="property__description__main__text">Description</span>
            </strong>
            <p class="property__description__main__text__description">
              {{ property.description }}
            </p>
          </section>
        </main>
      </section>
    </section>
  </el-container>
</template>

<script lang="ts">
import {
  defineComponent,
  onMounted,
  onUnmounted,
  PropType,
  reactive,
  ref,
  toRef,
  toRefs,
  watchEffect,
} from "vue";
import { IProperty, IPropertyFeature } from "@/Types/Property";
import GetScreenWidth from "@/Helpers/GetScreenWidth";
import { titleCase, getPrice } from "@/Helpers";
import PropertyService from "@/services/PropertyService";
import { List } from "@/Types";
import Carousel from "./Carousel.vue";

export default defineComponent({
  components: {
    Carousel,
  },
  props: {
    property: {
      type: Object as PropType<IProperty>,
      required: true,
    },
  },
  setup(props) {
    const { property } = toRefs(props);
    const images = reactive<List<string>>({ list: [] });
    const coverImage = ref("");
    const currentImage = ref("");
    watchEffect(() => {
      Object.assign(images, {
        list: property.value.images.map((image) => `${image.path}`),
      });
      coverImage.value = `${property.value.cover_image}`;
    });
    const features = ref<IPropertyFeature[] | undefined>([]);
    onMounted(() => {
      Object.assign(images, {
        list: property.value.images.map((image) => `${image.path}`),
      });
      coverImage.value = `${property.value.cover_image}`;
      currentImage.value = coverImage.value;
      features.value =
        property.value &&
        property.value?.features.filter((feature) => {
          return feature.value && feature.value != "no";
        });
    });

    function setCurrentImage(image: string): void {
      currentImage.value = image;
    }

    return {
      features,
      GetScreenWidth,
      images,
      currentImage,
      titleCase,
      getPrice,
      setCurrentImage,
    };
  },
});
</script>

<style lang="scss" scoped>
.el-container {
  display: flex;
  flex-flow: column;
  @media (min-width: 992px) {
    // padding: 0 17.5rem;
  }
}
.property {
  &__images-md {
    // display: flex;
    @media screen and (min-width: 769px) {
      display: none;
    }
  }
  @media screen and (min-width: 769px) {
    display: grid;
    grid-template-rows: repeat(2, auto);
    grid-template-columns: repeat(2, auto);
    padding: 0 3rem;
  }
  @media screen and (min-width: 769px) {
    width: 66vw;
    align-self: center;
  }
  &__images {
    @media screen and (max-width: 768px) {
      display: none;
    }
    display: flex;
    flex-flow: row nowrap;
    margin: 1rem;
    grid-row: 1 / span 1;
    grid-column: 1 / span 1;
    &__display {
      margin-right: 1rem;
    }
    &__list {
      @media screen and (max-width: 768px) {
        display: none;
      }
      grid-row: 1 / span 2;
      grid-column: 2;
      display: grid;
      grid-template-columns: repeat(2, auto);
      @media screen and (min-width: 1439px) {
        grid-template-columns: repeat(3, auto);
      }
      &__item {
        margin: 1rem;
        &__image {
          width: 100%;
          height: 100%;
        }
      }
    }
  }
  &__description {
    &__heading {
      display: flex;
      flex-flow: column nowrap;
      background-color: darkgray;
      color: white;
      padding: 0.125rem 1rem;
      &__price {
        margin-bottom: 0.5rem;
      }
      @media screen and (min-width: 767px) {
        flex-flow: row-reverse nowrap;
        justify-content: space-between;
        padding: 1rem 1rem;
        &__price {
          margin: 0;
          font-weight: bold;
        }
      }
      @media screen and (min-width: 1023px) {
        padding: 1rem 2rem;
      }
    }
    &__main {
      padding: 0.125rem 1rem;
      &__feature-list {
        display: flex;
        flex-flow: column nowrap;
        margin: 1rem 0;
      }
    }
  }
}
</style>

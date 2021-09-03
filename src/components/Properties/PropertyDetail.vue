<template>
  <div class="property-detail" id="affix-container" v-if="property">
    <div class="property">
      <h1 class="property__heading">
        <span class="property__heading__price">
          {{ formatter.format(property.price) }}
        </span>
        |
        <span class="property__heading__title">{{ property.title }}</span>
      </h1>
      <div class="property__images property-item">
        <el-carousel
          height="30rem"
          :autoplay="false"
          arrow="always"
          indicator-position="outside"
        >
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
      <div class="property__features property-item">
        <span class="property__features__heading">
          <h1 class="property__features__heading__text">Features</h1>
          <div class="property__features__heading__stats">
            <feature-icon :value="property.bedrooms" icon="bed.svg" />
            <feature-icon :value="property.bathrooms" icon="bath.svg" />
            <feature-icon :value="property.garages" icon="gar.svg" />
          </div>
        </span>
        <div class="property__features__list">
          <span class="property__features__list__item">
            <span>Bedrooms {{ property.bedrooms }}</span>
          </span>
          <span class="property__features__list__item">
            <span>Bathrooms {{ property.bathrooms }}</span>
          </span>
          <span class="property__features__list__item">
            <span>Garages {{ property.garages }}</span>
          </span>
        </div>
      </div>
    </div>
    <el-affix target="#affix-container" :offset="80">
      <div class="contact property-item">
        <el-form class="contact__form">
          <el-form-item>
            <el-input placeholder="Name"> </el-input>
          </el-form-item>
          <el-form-item>
            <el-input placeholder="Contact Number"> </el-input>
          </el-form-item>
          <el-form-item>
            <el-input placeholder="Email Address"> </el-input>
          </el-form-item>
          <el-form-item>
            <el-input type="textarea" placeholder="Email Address"> </el-input>
          </el-form-item>
          <el-form-item>
            <el-button> Send </el-button>
          </el-form-item>
        </el-form>
      </div>
    </el-affix>
  </div>
</template>

<script lang="ts">
import propertyApi from "@/services/property";
import { defineComponent, onMounted, onUnmounted, ref, watchEffect } from "vue";
import { useRoute } from "vue-router";
import FeatureIcon from "@/components/FeatureIcon.vue";

const formatter = new Intl.NumberFormat("en-ZA", {
  currency: "ZAR",
  style: "currency",
});

export default defineComponent({
  components: {
    FeatureIcon,
  },
  setup() {
    const property = ref();
    const route = useRoute();
    const fixedHeight = ref(300);
    console.log(fixedHeight.value);
    function setImageHost(image: string) {
      return `${process.env.VUE_APP_API_HOST}${image}`;
    }
    const onWindowResize = (e: any) => {
      console.log("re: ", e);
      fixedHeight.value = window.innerHeight / 4;
    };
    window.addEventListener("resize", onWindowResize);
    onUnmounted(() => {
      window.removeEventListener("resize", onWindowResize);
    });
    onMounted(() => {
      propertyApi.get(Number(route.params.id)).then((res) => {
        const { data } = res;
        property.value = data;
      });
    });
    return {
      property,
      formatter,
      fixedHeight,
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
    @media (min-width: 767px) {
      height: 30rem;
    }
  }
}
.property-item {
  border: 0.5px solid rgba($color: #888, $alpha: 0.5);
  margin-bottom: 2rem;
  padding: 1.75rem;
}

.property-detail {
  // display: grid;
  // grid-template-columns: 2fr 1fr;
  // gap: 1rem;
  display: flex;
  flex-flow: row nowrap;
  padding: 2rem;
  .contact {
    flex: 1;
    height: fit-content;
  }
  .property {
    flex: 2;
    &__images {
      border: none;
      padding: 0;
      @media (max-width: 1023px) {
      }
      &__image {
        width: 100%;
        @media (min-width: 767px) {
          width: 100%;
          max-height: 35rem;
        }
      }
    }
    &__features {
      &__heading {
        display: flex;
        flex-flow: row nowrap;
        justify-content: space-between;
        &__stats {
          display: flex;
          @media (max-width: 767px) {
            display: none;
          }
          flex-flow: row nowrap;
          align-items: center;
        }
      }
      &__list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(10rem, 1fr));
        grid-gap: 2rem;
        &__item {
          width: fit-content;
        }
      }
    }
  }
}
</style>

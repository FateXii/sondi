<template>
  <div class="property-detail" id="affix-container">
    <div class="property">
      <h1 class="property__heading">
        <span class="property__heading__price">
          {{ currencyFormatter.format(property.price) }}
        </span>
        |
        <span class="property__heading__title">{{ property.title }}</span>
      </h1>
      <div class="property__images property-item">
        <el-carousel
          :height="GetScreenWidth < 500 ? '20rem' : '30rem'"
          :autoplay="false"
          arrow="always"
        >
          <el-carousel-item v-for="image in property.images" :key="image">
            <img
              ref="propImage"
              class="property__images__image"
              :src="image.path"
            />
          </el-carousel-item>
        </el-carousel>
      </div>
      <div class="property__description property-item">
        <h3 class="property__description__title">
          {{ property.title }}
        </h3>
        <div class="property__decription__price">
          {{ currencyFormatter.format(property.price) }}
        </div>
        <div class="property__decription_address">
          {{ property.address.street }}
        </div>
        <h3 class="property__description__heading">
          {{ property.description_title }}
        </h3>
        <p class="property__description__text">
          {{ property.description }}
        </p>
      </div>
    </div>
    <div class="property-features property-item"></div>
    <div :class="['contact', 'property-item']">
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
  </div>
</template>

<script lang="ts">
import propertyApi from "@/services/property";
import { defineComponent, onMounted, onUnmounted, PropType } from "vue";
import { IProperty } from "@/interfaces/Property";
import { onWindowScroll } from "@/Helpers/General";
import GetScreenWidth from "@/Helpers/GetScreenWidth";

const currencyFormatter = new Intl.NumberFormat("en-ZA", {
  currency: "ZAR",
  style: "currency",
});

export default defineComponent({
  components: {
    // FeatureIcon,
  },
  props: {
    property: {
      type: Object as PropType<IProperty>,
      required: true,
    },
  },
  setup() {
    onUnmounted(() => {
      if (GetScreenWidth.value > 992) {
        window.removeEventListener("scroll", onWindowScroll);
      }
    });
    onMounted(() => {
      if (GetScreenWidth.value > 992) {
        window.addEventListener("scroll", onWindowScroll);
      }
    });

    return {
      currencyFormatter,
      GetScreenWidth,
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
    @media (max-width: 500px) {
      height: 20rem;
    }
  }
}
.property-item {
  border: 0.5px solid rgba($color: #888, $alpha: 0.5);
  margin-bottom: 2rem;
  padding: 1.75rem;
}

.property-detail {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 1rem;
  padding: 2rem;
  @media (max-width: 500px) {
    display: flex;
    flex-flow: column;
    padding: 0;
  }
  .contact {
    flex: 1;
    height: fit-content;
  }
  .property {
    height: fit-content;
    flex: 2;
    &__heading {
      font-size: 1.25rem;
      margin: 0;
      padding: 0.5rem 0.275rem;
    }
    &__description {
      padding: 1rem 2rem;
    }
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
  }
}
</style>

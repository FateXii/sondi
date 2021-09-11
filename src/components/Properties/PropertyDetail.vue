<template>
  <div class="property-detail" id="affix-container" v-if="property">
    <div class="property">
      <h1 class="property__heading">
        <span class="property__heading__price">
          {{ price }}
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
import { defineComponent, onMounted, onUnmounted, ref, watchEffect } from "vue";
import { useRoute } from "vue-router";
import FeatureIcon from "@/components/FeatureIcon.vue";

const currenyFormatter = new Intl.NumberFormat("en-ZA", {
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
    const price = ref("");
    function setImageHost(image: string) {
      return `${process.env.VUE_APP_API_HOST}/${image}`;
    }
    let contactWidth = Number();
    const onWindowScroll = (e: any) => {
      const propertyDetailContainer =
        document.getElementsByClassName("property")[0];
      const propertyContactInfo = document.getElementsByClassName("contact")[0];
      const {
        width,
        top: contactTop,
        bottom: contactBottom,
      } = propertyContactInfo.getBoundingClientRect();
      contactWidth = Math.max(width, contactWidth);
      const {
        top,
        right,
        bottom: propertyBottom,
      } = propertyDetailContainer.getBoundingClientRect();
      // console.log(`scroll: pT=${top}; cT=${contactTop}`);
      // console.log(
      //   `scroll: pB=${Math.round(propertyBottom)}; cB=${Math.round(
      //     contactBottom
      //   )}`
      // );
      const fixedPos = 200;
      if (
        top <= fixedPos &&
        Math.round(contactBottom) < Math.round(propertyBottom) &&
        contactTop >= fixedPos
      ) {
        if (propertyContactInfo) {
          propertyContactInfo.setAttribute(
            "style",
            `top:${fixedPos}px;` +
              `position:fixed;` +
              `left:calc(1rem + ${right}px);` +
              `width:${contactWidth}px;`
          );
        }
      } else if (top <= fixedPos && contactTop < fixedPos) {
        propertyContactInfo.setAttribute("style", `align-self:end;`);
      } else {
        propertyContactInfo.setAttribute("style", ``);
      }
    };
    window.addEventListener("scroll", onWindowScroll);
    onUnmounted(() => {
      window.removeEventListener("scroll", onWindowScroll);
    });
    onMounted(() => {
      propertyApi.get(Number(route.params.id)).then((res) => {
        const { data } = res;
        property.value = data;
        price.value = currenyFormatter.format(data.price);
      });
    });
    return {
      price,
      property,
      setImageHost,
      currenyFormatter,
    };
  },
});
</script>

<style lang="scss" scoped>
.fixed {
}
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
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 1rem;
  padding: 2rem;
  .contact {
    flex: 1;
    height: fit-content;
  }
  .property {
    height: fit-content;
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

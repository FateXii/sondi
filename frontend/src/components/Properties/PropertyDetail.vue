<template>
  <el-container v-loading="!property">
    <div class="property__cover property-item" v-if="property">
      <youtube-video
        v-if="property.video_url.length > 0"
        :src="property.video_url"
      />
      <el-image
        v-else
        :src="coverImage"
        fit="fill"
        style="width: 100%"
      ></el-image>
    </div>
    <main class="property-detail" id="affix-container">
      <div class="property" :id="`prop${property.id}`" v-if="property">
        <h1 class="property__heading">
          <span class="property__heading__price">
            {{ currencyFormatter.format(property.price) }}
          </span>
          |
          <span class="property__heading__title">{{ property.title }}</span>
        </h1>
        <div class="property__images property-item">
          <carousel :images="images.list" />
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
        <div class="property__features property-item">
          <h2>
            <span class="property__features__heading"> Features </span>
          </h2>
          <div
            class="property__feature__item"
            v-for="(feature, i) in property.features"
            :key="i"
          >
            <span class="property__feature__item__name">
              {{ feature.name }}: {{ " " }}
            </span>
            <span class="property__feature__item__value">
              {{ feature.value }}
            </span>
          </div>
        </div>
        <div class="property__agents property-item">
          <h2>Agents</h2>
          <div class="property__agents__container">
            <div
              class="property__agents__constainer__item"
              v-for="agent in property.agents"
              :key="agent.id"
            >
              <el-avatar
                shape="square"
                :size="75"
                fit="fill"
                :src="agent.image"
              ></el-avatar>

              <div class="property__agents__container__item__details">
                <span class="property__agents__container__item__details__name">
                  {{ agent.name }}
                </span>
                <span
                  class="property__agents__container__item__details__number"
                >
                  Call
                  <a href="tel:+">
                    {{ agent.phone_number }}
                  </a>
                </span>
                <span class="property__agents__container__item__details__email">
                  Email
                  <a href="Email:">
                    {{ agent.email }}
                  </a>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div
        :id="`prop${property && property.id}contact`"
        :class="['contact', 'property-item']"
      >
        <h2>Contact Us</h2>
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
    </main>
  </el-container>
</template>

<script lang="ts">
import {
  defineComponent,
  onMounted,
  onUnmounted,
  reactive,
  ref,
  toRefs,
  watchEffect,
} from "vue";
import { IProperty } from "@/Types/Property";
import GetScreenWidth from "@/Helpers/GetScreenWidth";
import Carousel from "./Carousel.vue";
import PropertyService from "@/services/PropertyService";
import { List } from "@/Types";
import YoutubeVideo from "./YoutubeVideo.vue";

const currencyFormatter = new Intl.NumberFormat("en-ZA", {
  currency: "ZAR",
  style: "currency",
});

export default defineComponent({
  components: {
    Carousel,
    YoutubeVideo,
  },
  props: {
    id: {
      type: String,
      required: true,
    },
  },
  setup(props) {
    const { id } = toRefs(props);
    const property = ref<IProperty | undefined>();
    function onWindowScroll() {
      let contactWidth = Number();
      const propertyDetailContainer = document.getElementById(
        `prop${property.value?.id}`
      );
      const propertyContactInfo = document.getElementById(
        `prop${property.value?.id}contact`
      );
      if (propertyContactInfo && propertyDetailContainer) {
        const {
          width,
          top: contactTop,
          bottom: contactBottom,
        } = propertyContactInfo.getBoundingClientRect();
        const {
          top,
          right,
          bottom: propertyBottom,
        } = propertyDetailContainer.getBoundingClientRect();
        contactWidth = Math.max(width, contactWidth);
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
          propertyContactInfo &&
            propertyContactInfo.setAttribute("style", `align-self:end;`);
        } else {
          propertyContactInfo && propertyContactInfo.setAttribute("style", ``);
        }
      }
    }
    onUnmounted(() => {
      if (GetScreenWidth.value > 767) {
        window.removeEventListener("scroll", onWindowScroll);
      }
    });
    const images = reactive<List<string>>({ list: [] });
    const coverImage = ref("");
    watchEffect(() => {
      PropertyService.get(Number(id.value)).then((response) => {
        property.value = response.data.data;
        Object.assign(images, {
          list: property.value.images.map((image) => `${image.path}`),
        });
        coverImage.value = `${property.value.cover_image}`;
      });
    });
    onMounted(() => {
      if (GetScreenWidth.value > 767) {
        window.addEventListener("scroll", onWindowScroll);
      }
      PropertyService.get(Number(id.value)).then((response) => {
        property.value = response.data.data;
        Object.assign(images, {
          list: property.value.images.map((image) => `${image.path}`),
        });
      });
    });

    return {
      currencyFormatter,
      GetScreenWidth,
      property,
      images,
      coverImage,
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
.property-item {
  border: 0.5px solid rgba($color: #888, $alpha: 0.5);
  margin-bottom: 2rem;
  padding: 1.75rem;
}
.property__cover {
  padding: 0;
}
.property-detail {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 1rem;
  padding: 2rem;
  @media (max-width: 767px) {
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
    &__agents {
      font-size: 0.825rem;
      display: flex;
      flex-flow: column nowrap;
      &__container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(20rem, 1fr));
        &__item {
          display: flex;
          flex-flow: row nowrap;
          margin-bottom: 1rem;
          .el-avatar {
            margin-right: 1rem;
            flex: 1;
            min-width: 5rem;
            max-width: 5rem;
          }
          &__details {
            flex: 3;
            display: flex;
            flex-flow: column nowrap;
          }
        }
      }
    }
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

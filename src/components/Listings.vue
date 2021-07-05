<template>
  <div class="buying" :id="id">
    <div class="buying__howto">
      <hr class="main-divider" />
      <div class="buying__howto__icon_row">
        <Icon
          icon-location="/icons/search.svg"
          alt-icon-description="icon of newspaper search"
          icon-label="Look For A House"
        />
        <Icon
          icon-location="/icons/like.svg"
          alt-icon-description="icon of thumbs up"
          icon-label="Find one you like"
        />
        <Icon
          icon-location="/icons/tick.svg"
          alt-icon-description="icon of a checkbox"
          icon-label="Mark It As Interesting"
        />
        <Icon
          icon-location="/icons/click.svg"
          alt-icon-description="icon of a of finger clicking"
          icon-label="Click On It"
        />
        <Icon
          icon-location="/icons/mail.svg"
          alt-icon-description="icon of an envelope"
          icon-label="Request Viewings"
        />
      </div>
      <hr class="main-divider" />
    </div>
    <div class="properties">
      <h1 class="properties__heading">
        Properties <span>{{ isBuying ? "For Sale" : "For Rent" }}</span>
      </h1>
      <el-button @click="toggleBuying" type="warning"
        >Go to {{ isBuying ? "rentals" : "sales" }}</el-button
      >
      <div class="properties__showings">
        <PropertyCarousel @currentlyViewing="getProperty" />
        <PropertyDescription :showInterest="true" :property="property" />
      </div>
      <el-button type="warning" @click="openDialog"> I'm interested </el-button>
    </div>
    <FormDialog />
  </div>
</template>

<script lang="ts">
import { onMounted, watch, computed, defineComponent, ref } from "vue";
import { SET_BUYING_FLAG, OPEN_MODAL } from "@/store/mutation-types";
import { Property } from "@/interfaces";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import PropertyCarousel from "./PropertyCarousel.vue";
import PropertyDescription from "./PropertyDescription.vue";
import FormDialog from "./FormDialog.vue";
import Icon from "./Icon.vue";
export default defineComponent({
  components: {
    PropertyCarousel,
    PropertyDescription,
    FormDialog,
    Icon,
  },
  setup() {
    const store = useStore();
    const router = useRouter();
    const property = ref<Property>();
    onMounted(() => {
      const initialProperty = computed(
        () => store.getters.getCurrentViewingProperty
      );
      if (initialProperty.value) {
        property.value = initialProperty.value;
      }
    });
    function getProperty(propertyIn: Property) {
      property.value = propertyIn;
    }
    const isBuying = computed(() => store.getters.isBuying());
    const id = ref("renting");
    watch(isBuying, (buying) => {
      id.value = buying ? "buying" : "renting";
    });

    const toggleBuying = () => {
      store.commit(SET_BUYING_FLAG, !isBuying.value);
      router.push(`#${!isBuying.value ? "renting" : "buying"}`);
    };
    const openDialog = () => store.commit(OPEN_MODAL);
    return {
      openDialog,
      getProperty,
      property,
      id,
      isBuying,
      toggleBuying,
    };
  },
});
</script>

<style scoped lang="scss">
.main-divider {
  width: 100%;
  height: 1rem;
  border: none;
  background-color: #f5e1bf;
  border-radius: 5rem;
}
.cta {
  text-decoration: none;
}
.properties {
  display: flex;
  flex-flow: column nowrap;
  align-items: center;
  margin-top: 5rem;
  &__heading {
    font-weight: 400;
    margin-bottom: 1rem;
    span {
      font-weight: 600;
      position: relative;
      &::before {
        content: "";
        background-color: #f5e1bf;
        height: 0.325rem;
        width: 100%;
        position: absolute;
        top: 1.25em;
        border-radius: 1rem;
      }
    }
  }
  &__viewings__btn {
    font-weight: 600;
  }
  &__showings {
    display: flex;
    flex-flow: row wrap;
    width: 100%;
    justify-content: center;
    padding: 5rem 0;
  }
}

.buying {
  margin: 3rem 0;
  &__howto {
    &__icon_row {
      display: flex;
      flex-flow: row wrap;
      justify-content: space-between;
      padding: 3rem 2rem;
    }
  }
}
</style>

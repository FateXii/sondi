<template lang="html">
  <div class="buying" :id="id">
    <div class="buying__howto">
      <IconRow />
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
      <el-button type="warning" @click="openInterestContactModal">
        I'm interested
      </el-button>
    </div>
    <FormDialog property="property" />
  </div>
</template>

<script lang="ts">
import { onMounted, watch, computed, defineComponent, ref } from "vue";
import { SET_BUYING_FLAG } from "@/store/mutation-types";
import { Property } from "@/interfaces";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import PropertyCarousel from "./Listings/PropertyCarousel.vue";
import PropertyDescription from "./Listings/PropertyDescription.vue";
import FormDialog from "./FormDialog.vue";
import IconRow from "./Listings/IconRow.vue";
import { manageContactModal } from "@/composables/manageContactModal";
export default defineComponent({
  components: {
    PropertyCarousel,
    PropertyDescription,
    FormDialog,
    IconRow,
  },
  setup() {
    const { interested, openContactModal } = manageContactModal();
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
    const openInterestContactModal = () => {
      interested.value = true;
      openContactModal();
    };
    return {
      openInterestContactModal,
      openContactModal,
      getProperty,
      property,
      id,
      isBuying,
      toggleBuying,
      publicPath: computed(() => process.env.BASE_URL),
    };
  },
});
</script>

<style scoped lang="scss">
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
}
</style>

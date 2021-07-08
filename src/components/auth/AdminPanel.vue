<template lang="html">
  <el-container class="admin-container">
    <el-main>
      <el-container class="admin">
        <h1 class="admin__heading">Admin Panel</h1>
        <div class="admin__button-box">
          <div
            class="admin__button-box__button"
            @click="openPropertyManagement = !openPropertyManagement"
          >
            <i class="el-icon-house admin__button-box__button__icon"></i>
            <span class="admin__button-box__button__text">
              Manage Properties
            </span>
          </div>
          <div class="admin__button-box__button">
            <i class="el-icon-user admin__button-box__button__icon"></i>
            <span class="admin__button-box__button__text"> Manage Users </span>
          </div>
          <div class="admin__button-box__button">
            <i class="el-icon-s-custom admin__button-box__button__icon"></i>
            <span class="admin__button-box__button__text">
              Manage Tenants
            </span>
          </div>
        </div>
      </el-container>
      <PropertyManagement
        @newProperty="addProperty"
        @editProperty="updateProperty"
        v-if="openPropertyManagement"
      />
    </el-main>
    <PropertyModal :property="property" />
  </el-container>
</template>

<script lang="ts">
import { defineComponent, reactive, ref } from "vue";
import PropertyManagement from "@/components/auth/PropertyManagement.vue";
import PropertyModal from "@/components/auth/PropertyModal.vue";
import managePropertyModal from "@/composables/managePropertyModal";
import { Property } from "@/interfaces";

export default defineComponent({
  components: {
    PropertyManagement,
    PropertyModal,
  },
  setup() {
    const openPropertyManagement = ref(false);
    const property = reactive({
      id: Number(),
      location: "",
      description: "",
      beds: Number(),
      baths: Number(),
      garages: Number(),
      buying: Boolean(),
      imageList: {
        coverImage: "",
        allImages: Array<string>(),
      },
      price: Number(),
      name: "",
      interested: Boolean(),
    });
    const { propertyModal, openPropertyModal, closePropertyModal } =
      managePropertyModal();
    const addProperty = () => {
      openPropertyModal();
    };
    const updateProperty = (_property: Property) => {
      const {
        id,
        name,
        location,
        description,
        beds,
        baths,
        garages,
        buying,
        imageList,
        price,
        interested,
      } = _property;
      property.id = id;
      property.name = name;
      property.location = location;
      property.description = description;
      property.beds = beds;
      property.baths = baths;
      property.garages = garages;
      property.buying = buying;
      property.imageList.coverImage = imageList.coverImage;
      property.imageList.allImages = imageList.allImages;
      property.price = price;
      property.interested = interested;
      openPropertyModal();
    };
    return {
      openPropertyManagement,
      addProperty,
      propertyModal,
      openPropertyModal,
      closePropertyModal,
      property,
      updateProperty,
    };
  },
});
</script>

<style scoped lang="scss">
.admin-container {
  flex-flow: column nowrap;
}
.admin {
  width: 100%;
  display: flex;
  flex-flow: column nowrap;
  align-items: center;
  &__button-box {
    display: flex;
    flex-flow: column nowrap;
    align-items: center;
    &__button {
      display: flex;
      flex-flow: column nowrap;
      background-color: #e6a23c;
      color: white;
      width: 8rem;
      height: 8rem;
      margin: 1rem 0;
      border-radius: 10%;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      &:hover {
        background-color: #e6a23ce0;
      }
      &__icon::before {
        height: 2rem;
        width: 2rem;
      }
      @media (min-width: 767px) {
        &:nth-child(2) {
          margin: 1rem;
        }
      }
    }
    @media (min-width: 767px) {
      flex-flow: row nowrap;
    }
  }
  @media (min-width: 767px) {
    padding: 0 3rem;
  }
}
</style>

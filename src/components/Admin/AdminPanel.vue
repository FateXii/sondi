<template lang="html">
  <el-menu
    default-active="1"
    class="el-menu-vertical-demo"
    background-color="#545c64"
    text-color="#fff"
    active-text-color="#ffd04b"
    mode="horizontal"
  >
    <el-menu-item index="1">
      <i class="el-icon-user"></i>
      <span>Manage Users</span>
    </el-menu-item>
    <el-menu-item index="2">
      <i class="el-icon-s-custom"></i>
      <span>Manage Tenants</span>
    </el-menu-item>
    <el-submenu index="3">
      <template #title>
        <i class="el-icon-house"></i>
        <span>Manage Properties</span>
      </template>
      <router-link to="/dashboard/new_property">
        <el-menu-item index="3-1">
          <template #title>
            <i class="el-icon-plus"></i>
            <span>New Property</span>
          </template>
        </el-menu-item>
      </router-link>
      <el-submenu index="3-2">
        <template #title>
          <i class="el-icon-view"></i>
          <span>View Properties</span>
        </template>
        <el-menu-item index="3-2-1"> View All Properties </el-menu-item>
        <el-menu-item index="3-2-2"> View Sectional Properties</el-menu-item>
        <el-menu-item index="3-2-3"> View Stand Alone Properties</el-menu-item>
      </el-submenu>
    </el-submenu>
  </el-menu>
  <el-container class="admin-container">
    <el-main>
      <router-view></router-view>
    </el-main>
    <!-- <el-main>
      <PropertyManagement
        @newProperty="addProperty"
        @editProperty="updateProperty"
      />
    </el-main>
    <PropertyModal :property="property" />
    <NewPropertyForm /> -->
  </el-container>
</template>

<script lang="ts">
import { defineComponent, ref, watchEffect } from "vue";
import managePropertyModal from "@/composables/managePropertyModal";
import { managePropertyListModal } from "@/composables/managePropertyListModal";
import { manageNewPropertyFormModal } from "@/composables/manageNewPropertyFormModal";
import { authManager } from "@/composables/authManager";
import { Property } from "@/interfaces";
import { useRouter } from "vue-router";

export default defineComponent({
  components: {},
  setup() {
    const {
      propertyModal,
      openPropertyModal,
      closePropertyModal,
      makeProperty,
    } = managePropertyModal();

    const { openPropertyListModal } = managePropertyListModal();
    const { openNewPropertyFormModal } = manageNewPropertyFormModal();

    const openPropertyManagement = ref(false);
    const property = ref(makeProperty(ref(undefined)));
    const addProperty = () => {
      openPropertyModal();
    };
    const updateProperty = (_property: Property) => {
      property.value = makeProperty(ref(_property));
      openPropertyModal();
    };
    const router = useRouter();
    const { loggedIn } = authManager();

    watchEffect(() => {
      if (!loggedIn) {
        router.push("/dashboard/login");
      }
    });

    return {
      openPropertyManagement,
      openNewPropertyFormModal,
      addProperty,
      propertyModal,
      openPropertyModal,
      closePropertyModal,
      openPropertyListModal,
      property,
      updateProperty,
    };
  },
});
</script>

<style scoped lang="scss">
.el-main {
  flex-flow: row nowrap;
  justify-content: center;
  @media (min-width: 767px) {
    padding: 0 10%;
  }
  @media (min-width: 1023px) {
    padding: 0 20%;
    // width: 60%;
    margin-top: 5vh;
  }
}
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
    @media (min-width: 767px) {
      flex-flow: row nowrap;
    }
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
  }
  @media (min-width: 767px) {
    padding: 0 3rem;
  }
}
</style>

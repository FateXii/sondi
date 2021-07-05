<template lang="html">
  <el-container>
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
        </div>
      </el-container>
      <PropertyManagement v-if="openPropertyManagement" />
    </el-main>
  </el-container>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import PropertyManagement from "@/components/auth/PropertyManagement.vue";
export default defineComponent({
  components: {
    PropertyManagement,
  },
  setup() {
    const openPropertyManagement = ref(false);
    return {
      openPropertyManagement,
    };
  },
});
</script>

<style scoped lang="scss">
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
        &:not(:nth-child(1)) {
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

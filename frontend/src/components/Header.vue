<template>
  <el-container id="header-container">
    <header class="header">
      <router-link to="/" class="header__logo">
        <img class="logo" src="@/assets/logo.svg" />
      </router-link>
      <div class="header__nav lg">
        <router-link to="/"> Home </router-link>
        <router-link to="#how-to"> How To </router-link>
        <router-link to="#properties"> Properties </router-link>
      </div>
      <div class="header__menu">
        <span class="header__menu__icon" @click="drawer = true">
          <img src="@/assets/icons/menu-icon.svg" alt="Hamburger Icon" />
        </span>
        <el-drawer v-model="drawer">
          <div class="header__nav sm">
            <router-link to="/"> Home </router-link>
            <router-link to="#how-to"> How To </router-link>
            <router-link to="#properties"> Properties </router-link>
          </div>
          <HeaderMenuItems class="header__menu__items" />
        </el-drawer>
      </div>
    </header>
  </el-container>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import { AuthManager } from "@/composables/AuthManager";
import { useRouter } from "vue-router";
import HeaderMenuItems from "@/components/Header/HeaderMenuItems.vue";
import ScreenWidth from "@/Helpers/GetScreenWidth";

export default defineComponent({
  components: {
    HeaderMenuItems,
  },
  setup() {
    const { loggedIn, user } = AuthManager();
    const drawer = ref(false);
    const router = useRouter();
    const goToDashboard = () => {
      router.push("/dashboard");
    };
    return {
      goToDashboard,
      drawer,
      loggedIn,
      user,
      ScreenWidth,
    };
  },
});
</script>

<style scoped lang="scss">
.header {
  &__logo {
    width: 10rem;
    .logo {
      width: 100%;
    }
  }

  display: flex;
  flex-flow: row nowrap;
  width: 100%;
  align-items: center;
  justify-content: space-between;
  padding: 1rem 2rem;
  @media (min-width: 767px) {
    padding: 1rem 0rem;
  }

  &__nav {
    display: flex;
    flex-flow: column nowrap;
    &.lg {
      display: none;
    }
    &.sm {
      display: flex;
    }
    @media (min-width: 992px) {
      flex-flow: row nowrap;
      justify-content: space-between;
      width: 25%;
      &.lg {
        display: flex;
      }
      &.sm {
        display: none;
      }
    }
  }
  &__menu {
    &__icon {
      display: flex;
      width: 2.5rem;
      img {
        width: 100%;
      }
    }
  }
}
</style>

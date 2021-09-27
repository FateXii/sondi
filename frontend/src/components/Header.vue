<template>
  <el-container id="header-container">
    <header class="header">
      <router-link to="/">
        <img class="logo" src="@/assets/logo.svg" />
      </router-link>
      <div class="header-menu">
        <span class="header-menu__icon" @click="drawer = true">
          <img src="@/assets/icons/menu-icon.svg" alt="Hamburger Icon" />
        </span>
        <el-drawer v-model="drawer" :size="ScreenWidth < 767 ? '80%' : '60%'">
          <HeaderMenuItems class="header-menu__items drawer" />
        </el-drawer>
        <HeaderMenuItems class="header-menu__items lg" />
      </div>
    </header>
  </el-container>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import { AuthManager } from "@/composables/AuthManager";
import { useRouter } from "vue-router";
import HeaderMenuItems from "@/components/HeaderMenuItems.vue";
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
.cta {
  background-color: #f5e1bf;
  color: black;
  text-align: center;
  display: inline;
  line-height: 1em;
  border-radius: 6rem;
  padding: 1.25rem 2rem;
  text-align: center;
}
#header-container {
  height: fit-content;
  flex-grow: 0;
}
.header {
  font-size: 1.875em;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: fit-content;
  a {
    display: flex;
    .logo {
      width: 10rem;
    }
  }
  padding: 1rem 2rem;
  @media (min-width: 1023px) {
    padding: 1rem 5rem;
  }
  @media (min-width: 767px) {
    padding: 1rem 1rem;
    font-size: 1.5em;
    .logo {
      img {
        width: 100%;
      }
    }
  }
}
.header-menu {
  &__icon {
    display: flex;
    width: 2.5rem;
    img {
      width: 100%;
    }
  }
  &__items.drawer {
    padding: 0 2rem;
  }
  .lg {
    display: none;
  }
}

@media (min-width: 767px) {
  .header-menu {
    .lg {
      display: flex;
      align-items: center;
      a {
        color: black;
        font-weight: 600;
      }
      & > * {
        margin-left: 1.5rem;
      }
    }
    &__icon {
      display: none;
    }
  }
}
</style>

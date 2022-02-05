<template>
  <el-menu class="header-menu">
    <el-menu-item class="header-menu__item">
      <el-button type="warning"> Contact </el-button>
    </el-menu-item>
    <el-menu-item class="header-menu__item">
      <el-button type="warning" @click="toggleLoggedIn" v-if="!user">
        Login
      </el-button>
      <el-dropdown split-button v-else trigger="click">
        {{ user ? (loggingOut ? "Logging Out" : `${user.name}`) : "Login" }}
        <template #dropdown>
          <el-dropdown-menu>
            <el-dropdown-item @click="toggleLoggedIn"
              ><span>Logout</span></el-dropdown-item
            >
          </el-dropdown-menu>
        </template>
      </el-dropdown>
    </el-menu-item>
  </el-menu>
  <!-- <div class="header-menu__items">
    >
    <a @click="setBuying(false)" class="info-link" href="#renting"> Renting </a>
  </div> -->
</template>
<script lang="ts">
import { defineComponent } from "vue";
import { useRouter } from "vue-router";
import { AuthManager } from "@/composables/AuthManager";
import useAuthStore from "@/store/auth";

export default defineComponent({
  setup() {
    const { logout, loggingOut } = AuthManager();
    const router = useRouter();
    const { user } = useAuthStore();
    const toggleLoggedIn = () => {
      if (!user.value) {
        router.push("/login");
      } else {
        logout();
        router.push("/");
      }
    };
    return {
      toggleLoggedIn,
      loggingOut,
      user,
    };
  },
});
</script>

<style lang="scss" scoped>
.header-menu {
  padding: 0;
  &__item {
    padding: 0 !important;
  }
}
</style>

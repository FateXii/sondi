<template lang="html">
  <div class="header-menu__items">
    <el-button
      type="warning"
      @click="toggleLoggedIn"
      :loading="loggingOut || loggingIn"
      >{{
        user
          ? loggingOut
            ? "Logging Out"
            : `Logout ${user?.name.split(" ")[0]}`
          : "Login"
      }}</el-button
    >
    <a @click="setBuying(true)" class="info-link" href="#buying"> Buying </a>
    <a @click="setBuying(false)" class="info-link" href="#renting"> Renting </a>
    <el-button type="warning" @click="openNormalContactModal">
      Contact
    </el-button>
  </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import { useRouter } from "vue-router";
import { AuthManager } from "@/composables/AuthManager";

export default defineComponent({
  setup() {
    const { loggedIn, user, logout, loggingOut, loggingIn } = AuthManager();
    const router = useRouter();
    const toggleLoggedIn = () => {
      if (!user) {
        router.push("/dashboard/login");
      } else {
        logout();
        router.push("/");
      }
    };
    return {
      toggleLoggedIn,
      loggingOut,
      loggingIn,
      loggedIn,
      user,
    };
  },
});
</script>

<style lang="scss" scoped>
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

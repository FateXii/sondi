<template>
  <el-menu>
    <el-menu-item>
      <a @click="setBuying(true)" class="info-link" href="#buying"> Buying </a>
    </el-menu-item>
    <el-menu-item>
      <a @click="setBuying(false)" class="info-link" href="#renting">
        Renting
      </a>
    </el-menu-item>
    <el-menu-item>
      <el-button type="warning"> Contact </el-button>
    </el-menu-item>
    <el-menu-item>
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
            <el-dropdown-item>Action 2</el-dropdown-item>
            <el-dropdown-item>Action 3</el-dropdown-item>
            <el-dropdown-item>Action 4</el-dropdown-item>
            <el-dropdown-item>Action 5</el-dropdown-item>
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
    const { loggedIn, logout, loggingOut, loggingIn } = AuthManager();
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

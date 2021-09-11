<template>
  <el-menu
    default-active="1"
    class="el-menu-vertical-demo"
    background-color="#545c64"
    text-color="#fff"
    active-text-color="#ffd04b"
    :mode="displayWidth > 767 ? 'horizontal' : 'vertical'"
  >
    <el-submenu v-if="isAdmin" index="1">
      <template #title>
        <i class="el-icon-user"></i>
        <span>Manage Users</span>
      </template>
      <router-link to="/dashboard/users">
        <el-menu-item index="1-1">
          <template #title>
            <i class="el-icon-view"></i>
            <span>View All Users</span>
          </template>
        </el-menu-item>
      </router-link>
      <el-submenu index="1-2">
        <template #title>
          <i class="el-icon-plus"></i>
          <span>New Users</span>
        </template>
        <router-link to="/dashboard/new_user?type='admin'">
          <el-menu-item index="1-2-1">
            <template #title>
              <span>Admin</span>
            </template>
          </el-menu-item>
        </router-link>
        <router-link to="/dashboard/new_user?type='agent'">
          <el-menu-item index="1-2-2">
            <template #title>
              <span>Agent</span>
            </template>
          </el-menu-item>
        </router-link>
      </el-submenu>
    </el-submenu>

    <el-submenu v-if="isAdmin || isAgent" index="2">
      <template #title>
        <i class="el-icon-s-custom"></i>
        <span>Manage Tenants</span>
      </template>
      <router-link to="/dashboard/new_user?type='tenant'">
        <el-menu-item index="2-1">
          <template #title>
            <i class="el-icon-plus"></i>
            <span>New Tenant</span>
          </template>
        </el-menu-item>
      </router-link>
      <router-link to="/dashboard/users">
        <el-menu-item index="2-2">
          <template #title>
            <i class="el-icon-view"></i>
            <span>View All Tenants</span>
          </template>
        </el-menu-item>
      </router-link>
    </el-submenu>

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
        <router-link to="/dashboard/properties">
          <el-menu-item index="3-2-1"> View All Properties </el-menu-item>
        </router-link>
        <el-menu-item index="3-2-2"> View Sectional Properties</el-menu-item>
        <el-menu-item index="3-2-3"> View Stand Alone Properties</el-menu-item>
      </el-submenu>
    </el-submenu>
  </el-menu>
  <el-container class="admin-container">
    <el-main>
      <router-view></router-view>
    </el-main>
  </el-container>
</template>

<script lang="ts">
import { computed, defineComponent, onUnmounted, ref } from "vue";
import useAuthStore from "@/store/auth";

export default defineComponent({
  components: {},
  setup() {
    const Auth = useAuthStore();
    const isLoggedIn = Auth.IsAthenticated.value;

    const isAdmin = computed(() => Auth.IsAdmin());
    const isAgent = computed(() => Auth.IsAgent);

    const displayWidth = ref(window.innerWidth);
    function onResize() {
      displayWidth.value = window.innerWidth;
    }
    window.addEventListener("resize", onResize);
    onUnmounted(() => {
      window.removeEventListener("resize", onResize);
    });
    return {
      isAdmin,
      isAgent,
      isLoggedIn,
      Auth,
      displayWidth,
    };
  },
});
</script>

<style scoped lang="scss">
.el-main {
  flex-flow: row nowrap;
  justify-content: center;
  padding: 1rem 0;
  @media (min-width: 767px) {
    // padding: 0 10%;
  }
  @media (min-width: 1023px) {
    // padding: 0 20%;s
    // width: 60%;
    margin-top: 5vh;
  }
}
.router-link {
  // display: inline-block;
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

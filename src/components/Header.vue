<template lang="html">
  <el-container>
    <header class="header">
      <router-link to="/">
        <img class="logo" :src="require(`../assets/logo.svg`)" />
      </router-link>
      <div class="header-menu" v-if="!admin">
        <span class="header-menu__icon" @click="drawer = true">
          <img
            :src="require('../assets/icons/menu-icon.svg')"
            alt="Hamburger Icon"
          />
        </span>
        <el-drawer v-model="drawer" size="90%">
          <div class="header-menu__items drawer">
            <router-link class="info-link" to="/admin"> admin </router-link>
            <a @click="setBuying(true)" class="info-link" href="#buying">
              Buying
            </a>
            <a @click="setBuying(false)" class="info-link" href="#renting">
              Renting
            </a>
            <el-button type="warning" @click="openNormalContactModal">
              Contact
            </el-button>
          </div>
        </el-drawer>
        <div class="header-menu__items lg">
          <router-link class="info-link" to="/admin"> admin </router-link>
          <a @click="setBuying(true)" class="info-link" href="#buying">
            Buying
          </a>
          <a @click="setBuying(false)" class="info-link" href="#renting">
            Renting
          </a>
          <el-button type="warning" @click="openNormalContactModal">
            Contact
          </el-button>
        </div>
      </div>
    </header>
  </el-container>
</template>

<script lang="ts">
import { computed, defineComponent, ref } from "vue";
import { manageContactModal } from "@/composables/manageContactModal";
import { useStore } from "vuex";
import { SET_BUYING_FLAG } from "../store/mutation-types";

export default defineComponent({
  setup() {
    const { interested, clearContactForm, openContactModal } =
      manageContactModal();
    const openNormalContactModal = () => {
      clearContactForm();
      interested.value = false;
      openContactModal();
    };
    const store = useStore();
    const drawer = ref(false);
    const setBuying = (buying: boolean) => {
      drawer.value = false;
      store.commit(SET_BUYING_FLAG, buying);
    };
    const admin = computed(() => store.state.authenticated);
    return {
      setBuying,
      drawer,
      openNormalContactModal,
      admin,
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
.header {
  font-size: 1.875em;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  a {
    display: flex;
    .logo {
      width: 10rem;
    }
  }
  padding: 1rem 2rem;
  @media (min-width: 767px) {
    padding: 1rem 8.75rem;
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

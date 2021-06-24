<template lang="html">
  <el-container>
    <header class="header">
      <NuxtLink to="/">
        <div class="logo"><img src="/sondi-frontend/logo.svg"/></div>
    </NuxtLink>
      <div class="header-menu">
        <a @click="toggleBuying" class="info-link" href="#buying"> Buying </a>
        <a @click="toggleBuying" class="info-link" href="#renting"> Renting </a>
        <NuxtLink class="cta" to="/"> Contact </NuxtLink>
      </div>
    </header>
  </el-container>
</template>

<script lang="ts">
import { defineComponent, computed } from '@vue/composition-api'
import { SET_BUYING_FLAG } from '../store/mutation-types'

export default defineComponent({
  setup(_, ctx) {
    const store = ctx.root.$store;
    const router = ctx.root.$router;
    const isBuying = computed(() => store.state.properties.buying);
    const toggleBuying =  () => {
      console.log("PPPPPPP")
      store.commit(`properties/${SET_BUYING_FLAG}`, !isBuying.value)
    };
    return {
      toggleBuying
    }
  },
})
</script>


<style scoped lang="scss">
.header {
  font-size: 1.875em;
  width:100%;
  display: flex;
  align-items:center;
  justify-content:space-between;
  .logo {
    img {
      width:100%;
    }
  }
  margin-bottom:2rem;
  padding: 0 2em;
}
.header-menu {
    display: flex;
    align-items: center;
    a {
      margin-left: 5rem;
      color:black;
      font-weight:600;
    }

}
a {
  text-decoration:none;
}
.cta {
  background-color: #F5E1BF;
  color: black;
  text-align:center;
  display: inline;
  line-height: 1em;
  border-radius: 6rem;
  padding:1.5rem 5.5rem;
}
</style>

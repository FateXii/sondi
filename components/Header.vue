<template lang="html">
  <el-container>
    <header class="header">
      <div class="logo"><img src="logo.svg"/></div>
      <div class="header-menu">
        <a class="info-link" href="#"> Buying </a>
        <a class="info-link" href="#"> Renting </a>
        <a class="cta" href="#"> Contact </a>
      </div>
    </header>
  </el-container>
</template>

<script lang="ts">
import { defineComponent } from '@vue/composition-api'

export default defineComponent({
  setup() {
    
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

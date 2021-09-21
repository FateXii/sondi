<template lang="html">
  <el-footer height="fit-content">
    <el-container class="footer">
      <div class="container">
        <span class="footer__logo">
          <router-link to="/">
            <img :src="require(`@/assets/logo-light.svg`)" alt="light logo" />
          </router-link>
        </span>
        <div class="footer__address">
          <span class="footer__address__line">312 Susan Street</span>
          <span class="footer__address__line">Wierda Park</span>
          <span class="footer__address__line">Centurion</span>
          <span class="footer__address__line">0157</span>
        </div>
      </div>
    </el-container>
  </el-footer>
</template>

<style lang="scss" scoped>
.el-footer {
  padding: 0;
  max-height: 20rem;
  background-color: #545c64;
  color: #fff;
  display: flex;
  flex-flow: row nowrap;
  justify-content: center;
  bottom: 0;
}
.footer {
  display: flex;
  flex-flow: column nowrap;
  align-items: center;
  padding: 2rem 8.375rem;
  width: 100%;
  height: 100%;
  overflow: hidden;
  @media screen and (min-width: 767px) {
    flex-flow: row nowrap;
    max-width: 67.5rem;
  }
  .container {
    display: flex;
    flex-flow: column nowrap;
    justify-content: space-between;
    align-items: flex-start;
    @media screen and (min-width: 767px) {
      flex-flow: row nowrap;
      align-items: center;
      width: 100%;
    }
  }
  &__logo {
    width: 10rem;
    margin: 1.5rem 0;
    @media screen and (min-width: 767px) {
      margin: 0;
    }
    img {
      width: 100%;
      height: 100%;
    }
  }
  &__address {
    display: flex;
    flex-flow: column nowrap;
  }
}
</style>

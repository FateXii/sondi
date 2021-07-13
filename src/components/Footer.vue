<template>
  <el-footer height="20vh">
    <el-container class="footer">
      <div class="footer__address">
        <span class="footer__address__line">312 Susan Street</span>
        <span class="footer__address__line">Wierda Park</span>
        <span class="footer__address__line">Centurion</span>
        <span class="footer__address__line">0157</span>
      </div>
    </el-container>
  </el-footer>
</template>

<style lang="scss" scoped>
.el-footer {
  padding: 0;
  max-height: 20rem;
}
.footer {
  display: flex;
  flex-flow: column nowrap;
  background-color: #c8c8cc;
  padding: 1rem 8.375rem;
  width: 100%;
  height: 100%;
  @media screen and (min-width: 767px) {
    flex-flow: row nowrap;
  }
  &__address {
    display: flex;
    flex-flow: column nowrap;
  }
}
</style>

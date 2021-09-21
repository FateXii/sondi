<template>
  <el-container>
    <el-image :src="require('@/assets/logo.svg')"></el-image>
    <h1>NOT FOUND</h1>
  </el-container>
</template>
<style lang="scss" scoped>
.el-container {
  flex-flow: column nowrap;
  align-items: center;
  justify-content: center;
  .el-image {
    width: 40%;
  }
  h1 {
    width: fit-content;
  }
}
</style>

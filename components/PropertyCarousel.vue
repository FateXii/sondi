<template>
  <el-carousel :autoplay="false" type="card">
    <el-carousel-item>
      <PropertyCard/>
    </el-carousel-item>
    <el-carousel-item>
      <PropertyCard/>
    </el-carousel-item>
    <el-carousel-item>
      <PropertyCard/>
    </el-carousel-item>
    <el-carousel-item>
      <PropertyCard/>
    </el-carousel-item>
    <el-carousel-item>
      <PropertyCard/>
    </el-carousel-item>
    <el-carousel-item>
      <PropertyCard/>
    </el-carousel-item>
    <el-carousel-item>
      <PropertyCard/>
    </el-carousel-item>
  </el-carousel>
</template>


<style lang="scss">
.el-carousel__item:nth-child(2n) {
    background-color: #99a9bf;
  }

  .el-carousel__item:nth-child(2n+1) {
    background-color: #d3dce6;
  }
.el-carousel {
  width: 40rem;
}
.el-carousel__container {
    height: 22.5rem;
}

</style>

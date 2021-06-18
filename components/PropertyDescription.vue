<template>
  <div class="property-description">
    <el-carousel class="property-description__images" :autoplay="false" trigger="click" >
      <el-carousel-item v-for="image in imageList" :key="image">
        <div class="property-description__images__image">
          <img :src="image" alt="image of house ____"/>
        </div>
      </el-carousel-item>
    </el-carousel>
    <div class="property-description__details">
      <div class="property-description__details__specs">
        <span class="property-description__details__specs__price">R 3 259 999 </span>
        <span class="property-description__details__specs__name">Farm House</span>
        <div class="property-description__details__specs__location">
          <img class="property-description__details__specs__location__icon"
            src="/icons/location.svg"
            alt="location droppoint"/>
          <span class="property-description__details__specs__location__text">Centurion</span>
        </div>
        <el-checkbox v-model="interested" label="I'm Interested" border></el-checkbox>
      </div>
      <div class="property-description__details__text">
        <p>
          Lorem ipsum dolor sit amet, consectetur adipisicing elit.
          Earum quisquam laudantium saepe nesciunt aut voluptate voluptas
          culpa ratione numquam provident?
        </p>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent,   } from '@vue/composition-api'
export default defineComponent({
  setup() {
    return {
      imageList: [
      "/images/pexels-curtis-adams-3288103.jpg",
      "/images/pexels-curtis-adams-3288102.jpg",
      "/images/pexels-curtis-adams-3288103.jpg",
      "/images/pexels-curtis-adams-3288104.jpg",
      ],
      interested: false,
    }
  },
})
</script>

<style scoped lang="scss">

.property-description {
  display: flex;
  flex-flow: column nowrap;
  width: 40rem;
  &__images {
    width: 100%;;
    &__image {
      img {
        width:100%
      }
    }
  }
  &__details {
    display: flex;
    padding: 1rem;
    flex-flow: row nowrap;
    width: 100%;
    &__specs {
      display: flex;
      flex-flow: column nowrap;
      font-weight: 500;
      &__location {
        display: flex;
        flex-flow: row nowrap;
        align-items: center;
        padding: .5rem 0;
        &__icon {
          height: 1.25rem;
          width: 1.25rem;
        }
        &__text {
          color: #989898;
          font-size: 1rem;
        }
      }
    }
    &__text {
      p {
        overflow-wrap: break-word;
        margin-left:1rem;
      }
    }
  }
}
</style>


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

<template>
  <div class="property-description" v-if="property && property !== undefined ">
    <el-carousel class="property-description__images" :autoplay="false" trigger="click" >
      <el-carousel-item 
        v-for="(image,index) in property.imageList.allImages" 
        :key="index">
        <div class="property-description__images__image">
          <img :src="image" alt="image of house ____"/>
        </div>
      </el-carousel-item>
    </el-carousel>
    <div class="property-description__details">
      <div class="property-description__details__specs">
        <span class="property-description__details__specs__price">R {{property.price}} </span>
        <span class="property-description__details__specs__name">{{ property.name }}</span>
        <div class="property-description__details__specs__location">
          <img class="property-description__details__specs__location__icon"
            src="/sondi-frontend/icons/location.svg"
            alt="location droppoint"/>
          <span class="property-description__details__specs__location__text">{{ property.location }}</span>
        </div>
        <el-checkbox 
          v-if="showInterest"
          v-model="interested" 
          label="I'm Interested"
          @change="toggleInterested"
          border></el-checkbox>
      </div>
      <div class="property-description__details__text">
        <p>
          {{property.description}}
        </p>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { watch, toRefs, defineComponent, ref  } from '@vue/composition-api'
import { Property } from '../types'
import { TOGGLE_INTERESTED } from '../store/mutation-types'
export default defineComponent({
  props: {
    showInterest: Boolean,
    property: {
      type: Property,
      required:true
    },
  },
  setup(props, ctx) {
    const store = ctx.root.$store;
    const {property} = toRefs(props);
    const interested = ref((property.value !== undefined && property.value !== null) ? property.value.interested : false);
    watch(property, () => {
      interested.value = (property.value !== undefined && property.value !== null) ? property.value.interested : false;
    })
    const toggleInterested = () => {
       store.commit(`properties/${TOGGLE_INTERESTED}`, property.value.id)
    };
    return {
      interested,
      toggleInterested,
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

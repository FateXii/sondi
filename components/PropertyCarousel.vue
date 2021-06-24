<template>
  <el-carousel :autoplay="false" type="card" 
      ref="currentlyViewing"
  >
    <el-carousel-item v-for="property in properties" :key="property.id" 
      :name="`${property.id}`"
    >
      <PropertyCard 
        :property="property"
      />
    </el-carousel-item>
  </el-carousel>
</template>

<script lang="ts">
import { watchEffect, defineComponent, ref, onMounted, computed  } from '@vue/composition-api'
import {LOAD_PROPERTIES} from '../store/action-types'
import { Carousel } from  'element-ui'
/* import { Property } from '../types/index' */
export default defineComponent({
  emits:['currentlyViewing'],
  setup(_, ctx) {
    const store = ctx.root.$store;
    const getProperties = () => store.dispatch(`properties/${LOAD_PROPERTIES}`);
    onMounted(()=> {
      getProperties()
    })
    const properties = computed(()=> store.getters['properties/getProperties']);
    const currentlyViewing = ref<InstanceType<typeof Carousel>>();
    watchEffect(() => {
      const current = currentlyViewing.value;
      if ( current ) {
        const currentActive = current?.$data.items.find((card:any) => card.active);
        if (currentActive) {
          ctx.emit('currentlyViewing', properties
              .value
              .find(
                (property: any) => property.id === Number(currentActive.name)
              ))
        }
      }
    })
    return {
      currentlyViewing,
      getProperties,
      properties
    }
  }
})
</script>


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

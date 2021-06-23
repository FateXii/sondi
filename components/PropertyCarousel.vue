<template>
  <el-carousel :autoplay="false" type="card" 
  >
    <el-carousel-item v-for="property in properties" :key="property.id" 
      :name="`${property.id}`"
      ref="currentlyViewing"
    >
      <PropertyCard 
        :property="property"
      />
    </el-carousel-item>
  </el-carousel>
</template>

<script lang="ts">
import { watchEffect, defineComponent, ref, onMounted, computed } from '@vue/composition-api'
import {LOAD_PROPERTIES} from '../store/action-types'
import { SET_VIEWING } from '../store/mutation-types'
import { Property } from '../types'
export default defineComponent({
  emits:['currentlyViewing'],
  setup(_, ctx) {
    const store = ctx.root.$store;
    const getProperties = () => store.dispatch(`properties/${LOAD_PROPERTIES}`);
    onMounted(()=> {
      getProperties()
    })
    const properties = computed<Property[]>(()=> store.getters['properties/getProperties']);
    const currentlyViewing = ref(null);
    watchEffect(() => {
      const current = currentlyViewing.value;
      if ( current ) {
        const currentActive = current.find((card:any) => card.active);
        if (currentActive) {
          console.log(`name: ${ currentActive.name }`)
          ctx.emit('currentlyViewing', properties
              .value
              .find(
                (property:Property) => property.id === Number(currentActive.name)
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

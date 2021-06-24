<template>
  <div class="buying" :id="id" >
    <div class="buying__howto">
      <hr class="main-divider"/>
      <div class="buying__howto__icon_row">
        <Icon 
          iconLocation="/sondi-frontend/icons/search.svg" 
          altIconDescription="icon of newspaper search" 
          iconLabel="Look For A House"/>
        <Icon 
          iconLocation="/sondi-frontend/icons/like.svg" 
          altIconDescription="icon of thumbs up" 
          iconLabel="Find one you like"/>
        <Icon 
          iconLocation="/sondi-frontend/icons/tick.svg" 
          altIconDescription="icon of a checkbox" 
          iconLabel="Mark It As Interesting"/>
        <Icon 
          iconLocation="/sondi-frontend/icons/click.svg" 
          altIconDescription="icon of a of finger clicking" 
          iconLabel="Click On It"/>
        <Icon 
          iconLocation="/sondi-frontend/icons/mail.svg"
          altIconDescription="icon of an envelope"
          iconLabel="Request Viewings"/>
      </div>
      <hr class="main-divider"/>
    </div>
    <div class="properties">
      <h1 class="properties__heading">Properties <span>{{ isBuying? 'For Sale': 'For Rent' }}</span></h1>
      <el-button @click="toggleBuying" type="warning">Go to {{isBuying ? 'rentals' : 'sales'}}</el-button>
      <div class="properties__showings">
        <PropertyCarousel @currentlyViewing="getProperty"/>
        <PropertyDescription :showInterest="true" :property="property"/>
      </div>
      <div class="properties__viewings">
        <NuxtLink to="/viewings" class="properties__viewings__btn cta">
          Reqeuest Viewings
        </NuxtLink>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { onMounted, watch, computed, defineComponent, ref  } from '@vue/composition-api'
import { SET_BUYING_FLAG } from '../store/mutation-types'
import { Property } from '../types'
export default defineComponent({
  setup(_, ctx) {
    const store = ctx.root.$store;
    const property =ref(null)
    onMounted(() => {
      const initialProperty = computed(()=> store.getters['properties/getCurrentViewingProperty'])
      if (initialProperty.value) {

        property.value = initialProperty.value;
      }
    })
    function getProperty(propertyIn:Property) {
      property.value = propertyIn;
    }
    const isBuying = computed(() => store.state.properties.buying);
    const id = ref('renting');
    watch(isBuying, (buying) => {
      id.value = buying ? 'buying' : 'renting'
    })
    
    const toggleBuying =  () => {
      store.commit(`properties/${SET_BUYING_FLAG}`, !isBuying.value)
      ctx.root.$router.push(`#${!isBuying.value? 'renting' : 'buying'}`)
    };
    return {
      getProperty,
      property,
      id,
      isBuying,
      toggleBuying
    }
  }
})
</script>

<style scoped lang="scss">
.main-divider {
  width: 100%;
  height: 1rem;
  border: none;
  background-color: #F5E1BF;
  border-radius: 5rem;
}
.cta {
  text-decoration: none;
}
.properties {
  display: flex;
  flex-flow: column nowrap;
  align-items: center;
  margin-top: 5rem;
  &__heading {
    font-weight: 400;
    margin-bottom: 1rem;
    span{
      font-weight: 600;
      position: relative;
      &::before {
        content: "";
        background-color: #F5E1BF;
        height: .325rem;
        width: 100%;
        position: absolute;
        top: 1.25em;
        border-radius: 1rem;
      }
    }
  }
  &__viewings__btn {
    font-weight:600;
  }
  &__showings{
    display: flex;
    width:100%;
    justify-content: space-between;
    padding:5rem 5rem;
  }
}

.buying{
  margin:3rem 0;
  &__howto {
    &__icon_row{
      display: flex;
      flex-flow: row nowrap;
      justify-content: space-between;
      padding: 3rem 2rem;
    }
  }
}


</style>


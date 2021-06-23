<template>
  <div class="container">
    <Header/>
    <div class="viewings">
      <div v-if="properties.length > 0" >
        <h1>You have selected the following properties to view</h1>
        <div 
          class="viewings__property-list" 
          v-for="property in properties" 
          :key="property.id">
          <PropertyCard class="viewings__property-list__card" :property="property"/>
          <PropertyDescription 
            :showInterest="false" 
            :property="property" 
            class="viewings__property-list__description"/>
        </div>
        <div class="viewings__form">
          <el-form ref="form" :model="viewingForm" label-width="7.5rem" size="mini">
            <el-form-item label="Name">
              <el-col :span="11">
                <el-input placeholder="First Name" v-model="viewingForm.name"></el-input>
              </el-col>
              <el-col :span="2"> &nbsp; </el-col>
              <el-col :span="11">
                <el-input placeholder="Last Name" v-model="viewingForm.surname"></el-input>
              </el-col>
            </el-form-item>
            <el-form-item label="Email">
              <el-input v-model="viewingForm.email"></el-input>
            </el-form-item>
            <el-form-item label="Please note:">
              <el-input v-model="viewingForm.note"></el-input>
            </el-form-item>
          </el-form>
        </div>
      </div>
      <div v-else>
        <h1>
          You have selected no properties to view
        </h1>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, computed, ref, watch } from '@vue/composition-api'
import { Property } from '../types'
export default defineComponent({
  setup(_, ctx) {
    const store = ctx.root.$store;
    const properties = computed(
      () => store
      .state
      .properties
      .list
      .filter((property:Property) => property.interested)
    );
    let viewingForm = {
      name:"",
      surname:"",
      email:"",
      notes:"",
    }
    return {
      properties,
      viewingForm
    }
  },
})
</script>

<style lang="scss" scoped>
.container {
  padding: 5rem 8rem 1rem 8rem;
}
.viewings {
  display: flex;
  justify-content: center;
  &__property-list{
    display: flex;
    flex-flow: row nowrap;
    padding:2rem 0;
    align-items: center;
    justify-content: center;
    &__description {
      margin: 0 1rem;
    }
  }
  &__form {
    width: 40rem;
  }
}
</style>

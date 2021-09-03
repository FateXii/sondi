<template lang="html">
  <el-container class="property-management">
    <h1>Manage Properties</h1>
    <div
      class="property-management__property-list"
      v-if="properties.length > 0"
    >
      <div
        class="property-management__property-list__item"
        v-for="property in properties"
        :key="property.id"
      >
        <PropertyCard
          class="property-management__property-list__item__card"
          :property="property"
        />
        <el-button-group
          class="property-management__property-list__item__button-row"
        >
          <el-popconfirm
            confirmButtonText="OK"
            cancelButtonText="No, Thanks"
            icon="el-icon-info"
            iconColor="red"
            title="Are you sure to delete this?"
          >
            <template #reference>
              <el-button type="danger" icon="el-icon-delete"></el-button>
            </template>
          </el-popconfirm>
          <el-button
            @click="editProperty(property.id)"
            type="primary"
            icon="el-icon-edit"
          ></el-button>
        </el-button-group>
      </div>
    </div>
  </el-container>
</template>

<script lang="ts">
import { defineComponent, onMounted, ref } from "vue";
import propertyApi from "@/services/property";
import PropertyCard from "@/components/PropertyCard.vue";

export default defineComponent({
  components: {
    PropertyCard,
  },
  setup() {
    const propertiesLoaded = ref(false);
    const loadingProperties = ref(false);
    const properties = ref([]);
    function loadProperties() {
      loadingProperties.value = true;
      propertyApi
        .getAll()
        .then((res) => {
          const { data } = res;
          properties.value = data;
          loadingProperties.value = false;
          console.log(properties.value);
        })
        .catch((e) => console.log(e));
    }
    onMounted(() => {
      loadProperties();
    });
    return {
      loadingProperties,
      loadProperties,
      properties,
    };
  },
});
</script>

<style lang="scss" scoped>
.property-management {
  display: flex;
  flex-flow: column nowrap;
  align-items: center;
  &__property-list {
    display: grid;
    grid-template-columns: min-content;
    grid-gap: 2rem;
    justify-content: center;
    width: 100%;
    margin-top: 2rem;
    @media (min-width: 767px) {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(20rem, 1fr));
      grid-gap: 2rem;
      justify-content: center;
    }
    &__item {
      border: 1px solid #e6a23c;
      padding: 1rem 0;
      text-align: center;
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    &__button-row {
      padding: 1rem 2rem;
      justify-content: center;
    }
  }
}
</style>

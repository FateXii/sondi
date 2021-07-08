<template lang="html">
  <el-container class="property-management">
    <h1>Manage Properties</h1>
    <el-button @click="newProperty" type="primary" icon="el-icon-plus"
      >Add New</el-button
    >
    <div
      class="property-management__property-list"
      v-if="properties.length > 0"
    >
      <div
        class="property-management__property-list__item"
        v-for="property in properties"
        :key="property.id"
      >
        <h2>{{ property.name }}</h2>
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
            @click="editProperty(property)"
            type="primary"
            icon="el-icon-edit"
          ></el-button>
        </el-button-group>
      </div>
    </div>
  </el-container>
</template>

<script lang="ts">
import { computed, defineComponent } from "vue";
import { useStore } from "vuex";
import PropertyCard from "@/components/PropertyCard.vue";
import { Property } from "@/interfaces";
export default defineComponent({
  components: {
    PropertyCard,
  },
  emits: ["editProperty", "newProperty"],

  setup(_, { emit }) {
    const store = useStore();
    const properties = computed(() => store.state.list);
    const editProperty = (property: Property) => {
      emit("editProperty", property);
    };
    const newProperty = () => {
      emit("newProperty");
    };
    return {
      properties,
      newProperty,
      editProperty,
    };
  },
});
</script>
<style scoped lang="scss">
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
      grid-template-columns: repeat(2, min-content);
      grid-gap: 2rem;
      justify-content: center;
    }
    @media (min-width: 767px) {
      display: grid;
      grid-template-columns: repeat(2, min-content);
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

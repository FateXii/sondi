<template>
  <el-container class="property-management">
    <h1>Manage Properties</h1>
    <el-button type="primary" icon="el-icon-plus">Add New</el-button>
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
          <el-button type="primary" icon="el-icon-edit"></el-button>
        </el-button-group>
      </div>
    </div>
  </el-container>
</template>
<script lang="ts">
import { computed, defineComponent, ref } from "vue";
import { useStore } from "vuex";
import PropertyCard from "@/components/PropertyCard.vue";
export default defineComponent({
  components: {
    PropertyCard,
  },
  setup() {
    const store = useStore();
    const properties = computed(() => store.state.list);
    return {
      properties,
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
    display: flex;
    flex-flow: column nowrap;
    align-items: center;
    width: 100%;
    &__item {
      margin: 2.5rem;
      border: 1px solid #e6a23c;
      padding: 1rem 0;
      text-align: center;
      &__button-row {
        padding: 1rem 2rem;
        justify-content: center;
      }
    }
  }
}
</style>

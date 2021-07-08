<template lang="html">
  <el-container class="property-management-dialog">
    <el-dialog
      @close="closePropertyModal"
      :title="operation"
      v-model="propertyModal"
    >
      <PropertyManagementForm :property="property" />
      <template #footer>
        <span class="dialog-footer">
          <el-button @click="dialogFormVisible = false">Cancel</el-button>
          <el-button type="primary" @click="dialogFormVisible = false"
            >Confirm</el-button
          >
        </span>
      </template>
    </el-dialog>
  </el-container>
</template>

<script lang="ts">
import { PropType, defineComponent, ref, toRef } from "vue";
import { Property } from "@/interfaces";
import managePropertyModal from "@/composables/managePropertyModal";
import PropertyManagementForm from "./PropertyManagementForm.vue";

export default defineComponent({
  props: {
    property: {
      type: Object as PropType<Property>,
    },
  },
  components: {
    PropertyManagementForm,
  },
  setup(props) {
    const property = toRef(props, "property");
    const editing = ref(false);
    const { propertyModal, openPropertyModal, closePropertyModal } =
      managePropertyModal();

    const operation = ref("Edit Property");
    if (property.value) {
      editing.value = true;
    } else {
      editing.value = true;
    }
    return {
      operation,
      propertyModal,
      openPropertyModal,
      closePropertyModal,
    };
  },
});
</script>

<style lang="scss">
.property-management-dialog > div.el-overlay {
  overflow: hidden;
}
.property-management-dialog > div.el-overlay > div {
  width: 100% !important;
  margin-top: 5vh !important;
  @media (min-width: 767px) {
    width: 80% !important;
  }
  @media (min-width: 1023px) {
    width: 60% !important;
    margin-top: 5vh !important;
  }
}
</style>

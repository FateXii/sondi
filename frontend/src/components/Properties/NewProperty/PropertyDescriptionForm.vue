<template>
  <div class="property__description__title">
    <el-form-item label="Description Title">
      <el-input v-model="property.title" />
    </el-form-item>
  </div>
  <div class="property__decription__price">
    <el-form-item label="Price">
      <el-input v-model="property.price" />
    </el-form-item>
  </div>
  <div class="property__decription_address">
    <el-form-item label="Address">
      <property-address @addressChange="addressChange" />
    </el-form-item>
  </div>
  <h3 class="property__description__heading">
    <el-form-item label="Description Heading">
      <el-input v-model="property.description.heading" />
    </el-form-item>
  </h3>
  <div class="property__description__text">
    <el-form-item label="Description">
      <el-input type="textarea" v-model="property.description.text" />
    </el-form-item>
  </div>
</template>

<script lang="ts">
import { defineComponent, reactive, watch } from "vue";
import PropertyAddress from "@/components/Properties/NewProperty/PropertyAddress.vue";
import { IAddressForm, IPropertyDescriptionForm } from "@/interfaces/Forms";

export default defineComponent({
  components: {
    PropertyAddress,
  },
  emits: {
    descriptionFormChange: (form: IPropertyDescriptionForm) =>
      (form && true) || false,
  },
  setup(_, { emit }) {
    const property = reactive<IPropertyDescriptionForm>({
      title: String(),
      price: Number(),
      address: {
        isSectional: Boolean(),
        sectionalId: Number(),
        address: {
          unit: String(),
          street: String(),
          city: String(),
          province: String(),
          postal_code: String(),
        },
      },
      description: {
        text: String(),
        heading: String(),
      },
    });
    function addressChange(addressFormData: IAddressForm) {
      Object.assign(property.address, addressFormData);
    }
    watch(property, (propertyForm) => {
      emit("descriptionFormChange", propertyForm);
    });
    return {
      addressChange,
      property,
    };
  },
});
</script>

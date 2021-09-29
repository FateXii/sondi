<template>
  <el-form v-model="addressForm">
    <el-form-item label="Street">
      <el-input v-model="addressForm.street" :disabled="isSectional" />
    </el-form-item>
    <el-form-item label="City">
      <el-input v-model="addressForm.city" :disabled="isSectional" />
    </el-form-item>
    <el-form-item label="Province">
      <el-input v-model="addressForm.province" :disabled="isSectional" />
    </el-form-item>
    <el-form-item label="Code">
      <el-input v-model="addressForm.postal_code" :disabled="isSectional" />
    </el-form-item>
  </el-form>
</template>

<script lang="ts">
import { IAddress } from "@/Types/Address";
import { defineComponent, PropType } from "vue";
export default defineComponent({
  props: {
    modelValue: {
      type: Object as PropType<IAddress>,
      required: true,
    },
    isSectional: {
      type: Boolean,
    },
  },
  emits: ["update:modelValue"],
  computed: {
    addressForm: {
      get(): IAddress {
        return this.modelValue;
      },
      set(addressForm: IAddress) {
        this.$emit("update:modelValue", addressForm);
      },
    },
  },
});
</script>

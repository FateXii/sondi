<template>
  <el-dialog v-model="centerDialogVisible" title="Warning" width="100%" center>
    <el-form
      label-position="top"
      @submit="
        () => {
          handleSubmit();
          centerDialogVisible = false;
        }
      "
    >
      <el-form-item label="Sectional Name">
        <el-input v-model="sectionalName"></el-input>
      </el-form-item>
      <el-form-item label="Sectional Type">
        <el-input v-model="sectionalType"></el-input>
      </el-form-item>
      <address-form v-model="address" :isSectional="false" />
    </el-form>
    <template #footer>
      <span class="dialog-footer">
        <el-button @click="centerDialogVisible = false">Cancel</el-button>
        <el-button
          type="primary"
          @click="
            () => {
              handleSubmit();
              centerDialogVisible = false;
            }
          "
        >
          Submit
        </el-button>
      </span>
    </template>
  </el-dialog>
</template>

<script lang="ts">
import GetError, { ResponseError } from "@/Helpers/GetError";
import SectionalService from "@/services/SectionalService";
import { IAddress } from "@/Types/Address";
import { defineComponent, reactive, ref } from "vue";
import AddressForm from "../AddressForm.vue";

export default defineComponent({
  components: { AddressForm },
  props: { modelValue: { type: Boolean, required: true } },
  emits: {
    "update:modelValue": (isOpen: boolean) => typeof isOpen === "boolean",
    newSectionalPropertyCreated: null,
  },
  computed: {
    centerDialogVisible: {
      get(): boolean {
        return this.modelValue;
      },
      set(isOpen: boolean) {
        this.$emit("update:modelValue", isOpen);
      },
    },
  },
  setup(_, { emit }) {
    const address = reactive<IAddress>(new IAddress());
    const sectionalName = ref("");
    const sectionalType = ref("");
    function handleSubmit() {
      SectionalService.create({
        name: sectionalName.value,
        type: sectionalType.value,
        ...address,
      })
        .then(() => {
          emit("newSectionalPropertyCreated");
        })
        .catch((error) => GetError(error as ResponseError));
      return;
    }
    return {
      address,
      handleSubmit,
      sectionalName,
      sectionalType,
    };
  },
});
</script>

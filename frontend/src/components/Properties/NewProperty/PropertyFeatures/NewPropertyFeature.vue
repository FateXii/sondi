<template>
  <el-dialog v-model="isOpen" title="Warning" width="100%" center>
    <el-form
      label-position="top"
      v-model="feature"
      @submit="
        () => {
          handleSubmit();
          isOpen = false;
        }
      "
    >
      <el-form-item label="Feature Name">
        <el-input v-model="feature.name"></el-input>
      </el-form-item>
      <el-form-item label="Feature Value">
        <el-input v-model="feature.value"></el-input>
      </el-form-item>
      <el-form-item label="Feature Type">
        <el-input v-model="feature.type"></el-input>
      </el-form-item>
    </el-form>
    <template #footer>
      <span class="dialog-footer">
        <el-button @click="isOpen = false">Cancel</el-button>
        <el-button
          type="primary"
          @click="
            () => {
              handleSubmit();
              isOpen = false;
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
import { defineComponent, reactive } from "vue";
import { Feature } from "@/Types/Feature";
import PropertyService from "@/services/PropertyService";
import GetError, { ResponseError } from "@/Helpers/GetError";

export default defineComponent({
  props: { modelValue: { type: Boolean, required: true } },
  emits: {
    "update:modelValue": (isOpen: boolean) => typeof isOpen === "boolean",
    newPropertyFeatureCreated: null,
  },
  computed: {
    isOpen: {
      get(): boolean {
        return this.modelValue;
      },
      set(isOpen: boolean) {
        this.$emit("update:modelValue", isOpen);
      },
    },
  },
  setup(_, { emit }) {
    const feature = reactive<Feature>(new Feature());
    function handleFormSubmit() {
      //TODO {Thendo}: Handle Property Feature Property Creation Api Calls
      PropertyService.createFeature(feature)
        .then(() => {
          emit("newPropertyFeatureCreated");
        })
        .catch((error) => GetError(error as ResponseError));
      return;
    }
    return {
      feature,
      handleFormSubmit,
    };
  },
});
</script>

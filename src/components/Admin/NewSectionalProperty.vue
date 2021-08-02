<template>
  <el-form
    label-position="top"
    label-width="100px"
    :model="sectionalPropertyFormData"
  >
    <el-form-item label="Type">
      <el-select
        v-model="sectionalPropertyFormData.type"
        placeholder="Sectional Type"
      >
        <el-option
          v-for="item in sectionalTypes"
          :key="item.value"
          :label="item.label"
          :value="item.value"
        >
        </el-option>
      </el-select>
    </el-form-item>
    <el-form-item
      :label="`${
        sectionalPropertyFormData.type
          ? capitalize(sectionalPropertyFormData.type)
          : 'Sectional'
      } name`"
    >
      <el-input v-model="sectionalPropertyFormData.name"></el-input>
    </el-form-item>
    <el-form-item label="Address">
      <el-form :model="sectionalPropertyFormData.address">
        <el-form-item label="Street">
          <el-input
            v-model="sectionalPropertyFormData.address.street"
          ></el-input>
        </el-form-item>
        <el-form-item label="City">
          <el-input v-model="sectionalPropertyFormData.address.city"></el-input>
        </el-form-item>
        <el-form-item label="Province">
          <el-select
            v-model="sectionalPropertyFormData.address.province"
            placeholder="Select"
          >
            <el-option
              v-for="item in PROVINCE_LIST"
              :key="item"
              :label="item"
              :value="item"
            >
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="Postal Code">
          <el-input
            v-model="sectionalPropertyFormData.address.postal_code"
          ></el-input>
        </el-form-item>
      </el-form>
    </el-form-item>
    <el-form-item label="Sectional Image">
      <input type="file" accept="image/*" @change="previewImage" />
    </el-form-item>
    <el-form-item>
      <el-button @click="createNewSectionalProperty" type="primary">
        Create
        {{
          `${
            sectionalPropertyFormData.type
              ? capitalize(sectionalPropertyFormData.type)
              : "Sectional Property"
          } `
        }}
      </el-button>
    </el-form-item>
  </el-form>
</template>

<script lang="ts">
import { defineComponent, reactive } from "vue";
import { newPropertyForm } from "@/composables/newPropertyForm";

import {
  ISectionalPropertyForm,
  newSectionalProperty,
} from "@/composables/newSectionalProperty";

interface ISectionalTypeLabel {
  value: string;
  label: string;
}

const capitalize = (word: string): string => {
  const splitWord = word.split("");
  return [splitWord[0].toUpperCase(), ...splitWord.slice(1)].join("");
};

export default defineComponent({
  setup() {
    const { PROVINCE_LIST, createSectionalProperty, createdSectionalProperty } =
      newSectionalProperty();
    const { setFormStatus } = newPropertyForm();
    const sectionalTypes: ISectionalTypeLabel[] = [
      { value: "apartment", label: "apartment/flat" },
      { value: "complex", label: "complex/estate" },
    ];
    const sectionalPropertyFormData = reactive<ISectionalPropertyForm>({
      type: "",
      name: "",
      address: {
        street: "",
        city: "",
        province: "gauteng",
        postal_code: "",
      },
    });

    const createNewSectionalProperty = () => {
      createSectionalProperty(sectionalPropertyFormData);
      if (createdSectionalProperty.value) {
        setFormStatus("sectionalUnit");
      }
    };

    const previewImage = (e: any) => {
      sectionalPropertyFormData.image = e.target.files[0];
    };
    return {
      previewImage,
      sectionalPropertyFormData,
      sectionalTypes,
      PROVINCE_LIST,
      createNewSectionalProperty,
      capitalize,
    };
  },
});
</script>

<style lang="scss" scoped>
.avatar-uploader .el-upload {
  border: 1px dashed #d9d9d9;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}
.avatar-uploader .el-upload:hover {
  border-color: #409eff;
}
.avatar-uploader-icon {
  font-size: 28px;
  color: #8c939d;
  width: 178px;
  height: 178px;
  line-height: 178px;
  text-align: center;
}
.avatar {
  width: 178px;
  height: 178px;
  display: block;
}
</style>

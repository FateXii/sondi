<template>
  <el-form>
    <el-form-item label="Sectional">
      <el-checkbox-button v-model="isSectional">
        {{ isSectional ? "Apartments/Complex" : "Stand Alone" }}
      </el-checkbox-button>
    </el-form-item>
    <el-form-item v-if="isSectional" label="Choose Section">
      <el-select v-model="selectedSection" filterable>
        <el-option
          v-for="sectional in sectionals"
          :key="sectional.id"
          :value="sectional.id"
          :label="sectional.name"
        >
          <span>{{ sectional.name }}</span> |
          <span>{{ sectional.type }}</span>
        </el-option>
        <template #empty>
          <el-button style="width: 100%">Create New</el-button>
        </template>
      </el-select>
    </el-form-item>
    <el-form-item v-if="isSectional" label="Unit">
      <el-input />
    </el-form-item>
    <el-form-item label="Street">
      <el-input v-model="address.street" :disabled="isSectional" />
    </el-form-item>
    <el-form-item label="City">
      <el-input v-model="address.city" :disabled="isSectional" />
    </el-form-item>
    <el-form-item label="Province">
      <el-input v-model="address.province" :disabled="isSectional" />
    </el-form-item>
    <el-form-item label="Code">
      <el-input v-model="address.postal_code" :disabled="isSectional" />
    </el-form-item>
  </el-form>
</template>
<script lang="ts">
import { IAddress } from "@/interfaces/Address";
import { IPropertyAddress } from "@/interfaces/Property";
import { ISectional } from "@/interfaces/Sectional";
import SectionalService from "@/services/SectionalService";
import { defineComponent, onMounted, ref, watch } from "vue";

export default defineComponent({
  setup() {
    const isSectional = ref(false);
    const sectionals = ref<ISectional[]>([]);
    const selectedSection = ref(1);
    const address = ref<IAddress | IPropertyAddress>({
      street: "",
      city: "",
      postal_code: "",
      province: "",
    });

    watch(isSectional, (sectional) => {
      if (!sectional) {
        address.value = {
          street: "",
          city: "",
          postal_code: "",
          province: "",
        };
      } else {
        const sect = sectionals.value.find(
          (sectional) => sectional.id === selectedSection.value
        );
        if (sect) {
          address.value = sect.address;
        }
      }
    });

    watch(selectedSection, (sectionalId) => {
      if (isSectional.value) {
        const sect = sectionals.value.find(
          (sectional) => sectional.id === sectionalId
        );
        if (sect) {
          address.value = sect.address;
        }
      } else {
        address.value = {
          street: "",
          city: "",
          postal_code: "",
          province: "",
        };
      }
    });
    onMounted(() => {
      SectionalService.getAll().then((response) => {
        sectionals.value = response.data.data;
        selectedSection.value = sectionals.value[0].id;
      });
    });
    return {
      isSectional,
      sectionals,
      selectedSection,
      address,
    };
  },
});
</script>

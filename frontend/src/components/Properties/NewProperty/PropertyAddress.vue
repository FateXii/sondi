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
      <el-input v-model="address.unit" />
    </el-form-item>
    <address-form v-model="address" :isSectional="isSectional" />
  </el-form>
</template>
<script lang="ts">
import { IAddress } from "@/interfaces/Address";
import { IAddressForm } from "@/interfaces/Forms";
import { IPropertyAddress } from "@/interfaces/Property";
import { ISectional } from "@/interfaces/Sectional";
import SectionalService from "@/services/SectionalService";
import { defineComponent, onMounted, reactive, ref, watch } from "vue";
import AddressForm from "../AddressForm.vue";

export default defineComponent({
  components: {
    AddressForm,
  },
  emits: {
    addressChange: (newAddress: IAddressForm) => {
      if (newAddress.isSectional) {
        return newAddress.address.unit !== "";
      } else {
        return true;
      }
    },
  },
  setup(_, { emit }) {
    const isSectional = ref(false);
    const sectionals = ref<ISectional[]>([]);
    const selectedSection = ref(1);
    const address = reactive<IPropertyAddress>(new IAddress());
    function assignSectionalAddressToAddressFieldOrClear(
      is_sectional: boolean,
      sectionalId: number
    ) {
      if (is_sectional) {
        const sect = sectionals.value.find(
          (sectional) => sectional.id === sectionalId
        );
        if (sect) {
          Object.assign(address, sect.address);
        }
      } else {
        Object.assign(address, new IAddress());
      }
    }

    watch([isSectional, selectedSection], ([sectional, sectionalId]) => {
      assignSectionalAddressToAddressFieldOrClear(sectional, sectionalId);
    });

    watch(address, (new_address) => {
      emit("addressChange", {
        isSectional: isSectional.value,
        sectionalId: selectedSection.value,
        address: new_address,
      });
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

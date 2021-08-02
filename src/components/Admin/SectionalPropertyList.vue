<template>
  <h1 class="property-form__heading">New sectional property</h1>
  <h2 class="property-form__heading">Select Sectional Property</h2>
  <div class="property-form__sectional-list">
    <SectionalCard
      v-for="sectional in sectionalProperties"
      :key="sectional.id"
      :sectionalProperty="sectional"
      @selectedSectionalProperty="addNewSectionalUnit"
    />
  </div>
  <el-button type="primary" @click="goToCreateNewSectionalProperty"
    >Create New Sectional Property</el-button
  >
</template>

<script lang="ts">
import { defineComponent, onMounted, ref } from "vue";
import SectionalCard from "@/components/Admin/SectionalCard.vue";

import { ISectionalPropertyModel } from "@/interfaces/apiTypes";
import IAxiosResponse from "@/interfaces/schemas";
import sectionalApi from "@/services/sectionalProperty";
/* import { manageNewPropertyFormModal } from "@/composables/manageNewPropertyFormModal"; */
/* import managePropertyModal from "@/composables/managePropertyModal"; */
/* import { newSectionalPropertyUnit } from "@/composables/newSectionalPropertyUnit"; */

export default defineComponent({
  emits: ["createNewSectionalProperty", "newUnitForSectional"],
  components: {
    SectionalCard,
  },
  setup(_, { emit }) {
    /* const { closeNewPropertyFormModal } = manageNewPropertyFormModal(); */
    /* const { openPropertyModal } = managePropertyModal(); */
    /* const { createSectionalProperty } = newSectionalPropertyUnit(); */
    const addNewSectionalUnit = (sectional: ISectionalPropertyModel) => {
      emit("newUnitForSectional", sectional);
    };
    const goToCreateNewSectionalProperty = () => {
      emit("createNewSectionalProperty");
    };
    const sectionalProperties = ref<ISectionalPropertyModel[]>([]);
    onMounted(() => {
      sectionalApi
        .getAll()
        .then((response: IAxiosResponse<ISectionalPropertyModel[]>) => {
          const { data } = response;
          sectionalProperties.value = data;
          console.log(data);
        })
        .catch((error) => console.log(error));
    });
    return {
      goToCreateNewSectionalProperty,
      sectionalProperties,
      addNewSectionalUnit,
    };
  },
});
</script>

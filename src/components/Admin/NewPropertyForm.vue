<template lang="html">
  <el-dialog
    v-model="newPropertyFormModal"
    :width="screenWidth < 767 ? '90vw' : '50vw'"
    @closed="formStatus = 'sectional'"
  >
    <el-container class="property-form" v-if="formStatus == 'sectional'">
      <SectionalPropertyList
        @createNewSectionalProperty="newSectionalProperty"
        @newUnitForSectional="newSectionalUnit"
      />
    </el-container>
    <el-container
      class="property-form"
      v-else-if="formStatus == 'sectionalDetails'"
    >
      <NewSectionalProperty />
    </el-container>
    <el-container
      class="property-form"
      v-else-if="formStatus == 'sectionalUnit'"
    >
      <NewSectionalUnit />
    </el-container>
    <el-container
      class="property-form"
      v-else-if="formStatus == 'existingSectionalNewUnit'"
    >
      <NewSectionalUnit :sectional="sectional" />
    </el-container>
  </el-dialog>
</template>
<script lang="ts">
import { defineComponent, ref } from "vue";
import NewSectionalProperty from "./NewSectionalProperty.vue";
import NewSectionalUnit from "./NewSectionalUnit.vue";
import SectionalPropertyList from "./SectionalPropertyList.vue";
import { manageNewPropertyFormModal } from "@/composables/manageNewPropertyFormModal";
import { newPropertyForm } from "@/composables/newPropertyForm";

import screenWidth from "@/composables/windowWidth";
import { ISectionalPropertyModel } from "@/interfaces/apiTypes";

export default defineComponent({
  components: {
    NewSectionalProperty,
    SectionalPropertyList,
    NewSectionalUnit,
  },
  setup() {
    const { newPropertyFormModal } = manageNewPropertyFormModal();
    const { formStatus, setFormStatus } = newPropertyForm();
    const newSectionalProperty = () => {
      setFormStatus("sectionalDetails");
    };
    const sectional = ref<ISectionalPropertyModel>();
    const newSectionalUnit = (sect: ISectionalPropertyModel) => {
      sectional.value = sect;
      setFormStatus("existingSectionalNewUnit");
    };

    return {
      formStatus,
      newSectionalUnit,
      sectional,
      newSectionalProperty,
      newPropertyFormModal,
      screenWidth,
    };
  },
});
</script>

<style lang="scss" scoped>
.property-form {
  display: flex;
  flex-flow: column nowrap;
  &__heading {
    font-size: 2em;
  }
  &__button-box {
    display: flex;
    flex-flow: column nowrap;
    align-items: center;
    @media (min-width: 767px) {
      flex-flow: row nowrap;
    }
  }
  &__sectional-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(16rem, 1fr));
    grid-gap: 2rem;
  }
}
</style>

<template lang="html">
  <el-dialog
    v-model="newPropertyFormModal"
    :width="screenWidth < 767 ? '90vw' : '50vw'"
    @closed="formStatus = 'sectional'"
  >
    <el-container class="property-form" v-if="formStatus == 'sectional'">
      <h1 class="property-form__heading">New sectional property</h1>
      <h2 class="property-form__heading">Select Sectional Property</h2>
      <div class="property-form__sectional-list">
        <SectionalCard @selectedSectionalProperty="addNewSubProperty" />
        <SectionalCard @selectedSectionalProperty="addNewSubProperty" />
        <SectionalCard @selectedSectionalProperty="addNewSubProperty" />
      </div>
      <el-button type="primary" @click="addNewSectionalProperty"
        >Create New Sectional Property</el-button
      >
    </el-container>
    <el-container
      class="property-form"
      v-else-if="formStatus == 'sectionalDetails'"
    >
      <el-form
        label-position="top"
        label-width="100px"
        :model="newSectionalProperty"
      >
        <el-form-item label="Type">
          <el-select v-model="sectionalType" placeholder="Select">
            <el-option
              v-for="item in sectionalTypeList"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            >
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item
          :label="`${
            newSectionalProperty.type
              ? capitalize(newSectionalProperty.type)
              : 'Sectional'
          } name`"
        >
          <el-input v-model="newSectionalProperty.name"></el-input>
        </el-form-item>
        <el-form-item label="Address">
          <el-input v-model="newSectionalProperty.address"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button @click="openPropertyModal" type="primary">
            Create
            {{
              `${
                newSectionalProperty.type
                  ? capitalize(newSectionalProperty.type)
                  : "Sectional Property"
              } `
            }}
          </el-button>
        </el-form-item>
      </el-form>
    </el-container>
  </el-dialog>
</template>
<script lang="ts">
import { defineComponent, reactive, ref, watch } from "vue";
import SectionalCard from "./SectionalCard.vue";
import { manageNewPropertyFormModal } from "@/composables/manageNewPropertyFormModal";
import managePropertyModal from "@/composables/managePropertyModal";
import screenWidth from "@/composables/windowWidth";

declare type FormStatus =
  | "sectional"
  | "sectionalDetails"
  | "sectionalUnit"
  | "standAlone"
  | "standAloneDetails";

interface ISectionalType {
  value: string;
  label: string;
}

const capitalize = (word: string): string => {
  let splitWord = word.split("");
  return [splitWord[0].toUpperCase(), ...splitWord.slice(1)].join("");
};

export default defineComponent({
  components: {
    SectionalCard,
  },
  setup() {
    const { newPropertyFormModal, closeNewPropertyFormModal } =
      manageNewPropertyFormModal();
    const { openPropertyModal } = managePropertyModal();
    const formStatus = ref<FormStatus>("sectional");
    const addNewSubProperty = () => {
      closeNewPropertyFormModal();
      openPropertyModal();
    };
    const addNewSectionalProperty = () => {
      formStatus.value = "sectionalDetails";
    };

    const sectionalTypeList: ISectionalType[] = [
      { value: "apartment", label: "apartment/flat" },
      { value: "complex", label: "complex/estate" },
    ];
    const sectionalType = ref("");
    const newSectionalProperty = reactive({
      type: "",
      name: "",
      address: "",
    });
    watch(sectionalType, (newSectionalType) => {
      newSectionalProperty.type = newSectionalType;
    });
    return {
      capitalize,
      formStatus,
      addNewSubProperty,
      addNewSectionalProperty,
      sectionalType,
      sectionalTypeList,
      newSectionalProperty,
      newPropertyFormModal,
      openPropertyModal,
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

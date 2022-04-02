<template lang="html">
  <property-details v-if="property" :property="property"></property-details>
</template>

<script lang="ts">
import PropertyService from "@/services/PropertyService";
import { List } from "@/Types";
import { IProperty, IPropertyFeature } from "@/Types/Property";
import {
  defineComponent,
  onMounted,
  reactive,
  ref,
  toRefs,
  watchEffect,
} from "vue";
import PropertyDetails from "@/components/Properties/PropertyDetail.vue";
export default defineComponent({
  components: {
    PropertyDetails,
  },
  props: {
    id: {
      type: String,
      required: true,
    },
  },
  setup(props) {
    const { id } = toRefs(props);
    const property = ref<IProperty | undefined>();
    onMounted(() => {
      PropertyService.get(Number(id.value)).then((response) => {
        property.value = response.data.data;
      });
    });

    return {
      property,
    };
  },
});
</script>

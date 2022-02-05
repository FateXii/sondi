<template>
  <div class="properties" id="how-to">
    <IconRow />
    <PropertyList id="properties" />
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import PropertyList from "@/components/Properties/PropertyList.vue";
import IconRow from "@/components/Listings/IconRow.vue";
export default defineComponent({
  components: {
    PropertyList,
    IconRow,
  },
  setup() {
    return;
  },
});
</script>

<style scoped lang="scss">
.cta {
  text-decoration: none;
}
.properties {
  display: flex;
  flex-flow: column nowrap;
  align-items: center;
  margin-top: 5rem;
  &__viewings__btn {
    font-weight: 600;
  }
  &__showings {
    display: flex;
    flex-flow: row wrap;
    width: 100%;
    justify-content: center;
    padding: 5rem 0;
  }
}
</style>

<template lang="html">
  <div class="process-card">
    <div class="process-card__header">
      <Icon
        :icon-location="require('@/assets/icons/search.png')"
        alt-icon-description="magnifying glass with a house in focus"
      />
    </div>
    <div class="process-card__description">
      <div class="process-card__description__heading">
        <h1>Search</h1>
      </div>
      <div class="process-card__description__text">
        <p>
          Use the search functionalities provided on the site to find your
          perfect home
        </p>
      </div>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import Icon from "./Icon.vue";
export default defineComponent({
  components: {
    Icon,
  },
});
</script>
<style lang="scss" scoped>
.process-card {
  border-radius: 2rem;
  background-color: #fff;
  padding: 1rem;
  height: 30vh;
  width: 25vw;
  box-shadow: 0.25rem 0.25rem 0.1rem #66cc66;
  border: 1px solid #66cc66;

  // opacity: 60%;
}
</style>

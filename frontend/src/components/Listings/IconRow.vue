<template lang="html">
  <el-container>
    <hr class="main-divider" />
    <div class="icon-row">
      <Icon
        icon-location="@/assets/icons/search.svg"
        alt-icon-description="icon of newspaper search"
        icon-label="Look For A House"
      />
      <Icon
        icon-location="@/assets/icons/like.svg"
        alt-icon-description="icon of thumbs up"
        icon-label="Find one you like"
      />
      <Icon
        icon-location="@/assets/icons/tick.svg"
        alt-icon-description="icon of a checkbox"
        icon-label="Mark It As Interesting"
      />
      <Icon
        icon-location="@/assets/icons/click.svg"
        alt-icon-description="icon of a of finger clicking"
        icon-label="Click On It"
      />
      <Icon
        icon-location="@/assets/icons/mail.svg"
        alt-icon-description="icon of an envelope"
        icon-label="Request Viewings"
      />
    </div>
    <hr class="main-divider" />
  </el-container>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Icon from "../Icon.vue";
export default defineComponent({
  components: {
    Icon,
  },
});
</script>

<style lang="scss" scoped>
.el-container {
  flex-flow: column nowrap;
}
.main-divider {
  width: 100%;
  height: 1rem;
  border: none;
  background-color: #f5e1bf;
  border-radius: 5rem;
}
.icon-row {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(10rem, 1fr));
  justify-content: center;
  justify-items: center;
  width: 90vw;
  max-width: 950px;
}
</style>

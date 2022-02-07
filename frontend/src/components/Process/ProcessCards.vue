<template lang="html">
  <div class="process-card-grid">
    <process-card
      icon-location="./icons/search.png"
      alt-icon-description="magnifying glass with a house in focus"
      iconLabel="Search"
      class="process-card-grid__item"
    >
      <p>
        Use the search functionalities provided on the site to find your perfect
        home.
      </p>
    </process-card>
    <process-card
      icon-location="./icons/list.png"
      alt-icon-description="A list"
      iconLabel="Shortlist"
      class="process-card-grid__item"
    >
      <p>Shortlist homes that meet your requirements.</p>
    </process-card>
    <process-card
      icon-location="./icons/phone.png"
      alt-icon-description="An image of a phone"
      iconLabel="Contact Us"
      class="process-card-grid__item"
    >
      <p>
        With your shortlist created, contact Sondi with a list of the homes you
        wish to view.
      </p>
    </process-card>
    <process-card
      icon-location="./icons/keys.png"
      alt-icon-description="A handk holding out a key"
      iconLabel="Make An Offer"
      class="process-card-grid__item"
    >
      <p>
        After a tour of the homes you shortlisted choose one you like. Make an
        offer. If its accepted?. Move in.
      </p>
    </process-card>
  </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import ProcessCard from "@/components/Process/ProcessCard.vue";
export default defineComponent({
  components: {
    ProcessCard,
  },
});
</script>
<style lang="scss" scoped>
.process-card-grid {
  &__item {
    border-radius: 2rem;
    background-color: #fff;
    padding: 3rem;
    box-shadow: 0.25rem 0.25rem 0.1rem #6699cc;
    border: 1px solid #6699cc;
    margin-bottom: 1rem;
    @media screen and (min-width: 767px) {
      margin: 0.5rem 0.5rem;
    }
  }
  @media screen and (min-width: 767px) {
    display: grid;
    grid-template-columns: repeat(2, auto);
    grid-template-rows: repeat(2, auto);
  }
}
</style>

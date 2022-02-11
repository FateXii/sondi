<template lang="html">
  <div id="contact" class="contact">
    <div class="contact__form">
      <contact-form class="contact__form__fields"></contact-form>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import ContactForm from "./ContactForm.vue";
export default defineComponent({
  components: {
    ContactForm,
  },
  setup() {
    return {};
  },
});
</script>
<style lang="scss" scoped>
.contact {
  background-image: url("../assets/contact.png");
  height: 90vh;
  background-position: 6rem -51vh;
  display: grid;
  @media screen and (min-width: 767px) {
    grid-template-columns: repeat(2, 50vw);
    background-position: -50vw -51vh;
  }
  @media screen and (min-width: 1441px) {
    background-position: 12.8vw -45vh;
  }
  &__form {
    display: flex;
    flex-flow: column nowrap;
    justify-content: center;
    align-items: center;
    width: 100%;
    @media screen and (min-width: 767px) {
      grid-column: 2;
      width: 70%;
    }
    &__fields {
      padding: 1rem 1rem;
      @media screen and (min-width: 767px) {
        border: 0.1rem solid white;
        border-radius: 2rem;
        padding: 1rem 3rem;
      }
    }
  }
}
</style>

<template>
  <el-dialog title="Request Viewing" v-model="dialog">
    <el-form class="contact-modal__form" :model="formInfo">
      <el-form-item label="Name">
        <el-input v-model="formInfo.name" autocomplete="off"></el-input>
      </el-form-item>
      <el-form-item label="Email">
        <el-input type="email" v-model="formInfo.email"></el-input>
      </el-form-item>
      <el-form-item label="Phone Number">
        <el-input type="tel" v-model="formInfo.number"></el-input>
      </el-form-item>
      <el-form-item label="Message">
        <el-input
          class="contact-modal__form__message"
          type="textarea"
          v-model="formInfo.message"
        ></el-input>
      </el-form-item>
    </el-form>
    <template #footer>
      <span class="dialog-footer">
        <el-button type="danger" @click="closeContactModal">Cancel</el-button>
        <el-button type="warning" @click="() => {}">Send Request</el-button>
      </span>
    </template>
  </el-dialog>
</template>
<script lang="ts">
import { Property } from "@/interfaces";

import { manageContactModal } from "@/composables/manageContactModal";
import { defineComponent, PropType, toRef, watch } from "vue";

export default defineComponent({
  props: {
    property: {
      type: Object as PropType<Property>,
    },
  },
  setup(props) {
    const {
      interested,
      dialog,
      formInfo,
      openContactModal,
      closeContactModal,
    } = manageContactModal();
    const property = toRef(props, "property");
    watch(formInfo, () => {
      if (interested.value && property && property.value) {
        const phoneNumber = `\t Phone: ${formInfo.number}`;
        const email = `\t Email: ${formInfo.email}`;
        const line1 = `Hello.`;
        const line2 = `My name is ${formInfo.name}.`;
        const line4 = `Please contact me at:`;
        const line5 = `${formInfo.number.length ? phoneNumber : ""}`;
        const line6 = `${formInfo.email.length ? email : ""}`;
        formInfo.message = [line1, line2, line4, line5, line6].join("\n");
      }
    });

    return {
      formInfo,
      dialog,
      closeContactModal,
      openContactModal,
    };
  },
});
</script>
<style lang="scss">
.buying > div.el-overlay > div {
  width: 100% !important;
  @media (min-width: 767px) {
    width: 80% !important;
  }
  @media (min-width: 1023px) {
    width: 60% !important;
  }
}
.contact-modal {
  &__form {
    &__message {
      height: fit-content;
    }
  }
}
</style>

<template>
  <el-dialog title="Request Viewing" v-model="dialog">
    <el-form :model="form">
      <el-form-item label="Name">
        <el-input v-model="form.name" autocomplete="off"></el-input>
      </el-form-item>
      <el-form-item label="Email">
        <el-input type="email" v-model="form.email"></el-input>
      </el-form-item>
      <el-form-item label="Phone Number">
        <el-input type="tel" v-model="form.number"></el-input>
      </el-form-item>
      <el-form-item label="Message">
        <el-input type="textarea" v-model="form.message"></el-input>
      </el-form-item>
    </el-form>
    <template #footer>
      <span class="dialog-footer">
        <el-button type="danger" @click="closeDialog">Cancel</el-button>
        <el-button type="warning" @click="sendRequest">Send Request</el-button>
      </span>
    </template>
  </el-dialog>
</template>
<script lang="ts">
import { Property } from "@/interfaces";
import {
  CLOSE_MODAL,
  OPEN_MODAL,
  TOGGLE_INTERESTED,
} from "@/store/mutation-types";
import { computed, defineComponent, reactive, ref, watch } from "vue";
import { useStore } from "vuex";

export default defineComponent({
  setup() {
    const store = useStore();
    const dialog = ref<boolean>();
    watch(
      computed(() => store.state.formModal),
      (value) => {
        dialog.value = value;
      }
    );
    watch(dialog, (value) => {
      if (value) {
        store.commit(OPEN_MODAL);
      } else {
        store.commit(CLOSE_MODAL);
      }
    });
    const closeDialog = () => store.commit(CLOSE_MODAL);
    const sendRequest = () => {
      store.commit(CLOSE_MODAL);
      store.commit(
        TOGGLE_INTERESTED,
        store.getters.getCurrentViewingProperty.id
      );
    };
    const form = reactive({
      name: "",
      email: "",
      message: "",
      number: "",
    });
    watch(form, () => {
      const property: Property = store.getters.getCurrentViewingProperty;
      const phoneNumber = `\t Phone: ${form.number}`;
      const email = `\t Email: ${form.email}`;
      const line1 = `Hello.`;
      const line2 = `My name is ${form.name}.`;
      const line3 = `I am interested in ${property.name}.`;
      const line4 = `Please contact me at:`;
      const line5 = `${form.number.length ? phoneNumber : ""}`;
      const line6 = `${form.email.length ? email : ""}`;
      form.message = [line1, line2, line3, line4, line5, line6].join("\n");
    });

    return {
      form,
      dialog,
      closeDialog,
      sendRequest,
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
</style>
<style lang="scss" scoped>
.el-dialog {
  width: 100%;
}
</style>

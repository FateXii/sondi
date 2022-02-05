<template lang="html">
  <div class="contact-form">
    <h1 class="contact-form__heading">Contact Us</h1>
    <el-form ref="contactForm" :model="message" label-width="80px">
      <el-form-item label="Name">
        <el-input v-model="message.sender" placeholder="Name"></el-input>
      </el-form-item>
      <el-form-item label="Email">
        <el-input
          v-model="message.email"
          placeholder="Email Address"
        ></el-input>
      </el-form-item>
      <el-form-item label="Message">
        <el-input
          v-model="message.message"
          :autosize="{ minRows: 2, maxRows: 4 }"
          type="textarea"
          placeholder="Please input"
        >
        </el-input>
      </el-form-item>
      <el-form-item>
        <el-button type="warning"> Send </el-button>
      </el-form-item>
    </el-form>
  </div>
</template>
<script lang="ts">
import { defineComponent, reactive } from "vue";
export default defineComponent({
  setup() {
    const message = reactive({
      sender: "",
      email: "",
      message: "",
    });
    // const contact
    return {
      message,
    };
  },
});
</script>
<style lang="scss" scoped>
.contact-form {
  &__heading {
    text-align: center;
  }
  width: 100%;
  color: white;
}
</style>
<style lang="scss">
#contact > div > div > form > div > label {
  color: white;
}
</style>

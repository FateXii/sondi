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
        <el-button type="warning" @click="sendMessage" v-loading="loading">
          Send
        </el-button>
      </el-form-item>
    </el-form>
  </div>
</template>
<script lang="ts">
import GetError, { ResponseError } from "@/Helpers/GetError";
import Messages from "@/services/Messages";
import { IMessage } from "@/Types/Message";
import { ElMessage } from "element-plus";
import { defineComponent, reactive, ref } from "vue";
export default defineComponent({
  setup() {
    const loading = ref(false);
    const message = reactive({
      sender: "",
      email: "",
      message: "",
    });
    function sendMessage() {
      loading.value = true;
      let newMessage: IMessage = {
        to: "info@sondi.co.za",
        from: message.email,
        message: message.message,
        subject: `Request for information from website by ${message.sender}`,
        type: "Enquiry",
      };

      Messages.create(newMessage)
        .then(() => {
          loading.value = false;
          ElMessage({
            message: "Message sent.",
            type: "success",
          });
        })
        .catch((e) => {
          loading.value = false;
          ElMessage({
            message: "Failed.",
            type: "error",
          });
          GetError(e as ResponseError);
        });
    }
    return {
      message,
      loading,
      sendMessage,
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

<template>
  <el-container class="new-user" v-loading="loading">
    <el-form
      ref="userCreationForm"
      v-if="role !== 'tenant'"
      class="new-user__form"
      :rules="userValidator"
      :model="user"
    >
      <h1>Add New {{ capitalize(role) }}</h1>
      <el-alert
        title="Invalid Credentials"
        type="error"
        show-icon
        v-for="(error, i) in validationErrors"
        :key="i"
      >
        {{ error }}
      </el-alert>
      <el-alert
        title="Invalid input"
        type="error"
        show-icon
        v-if="!validForm"
      ></el-alert>
      <el-descriptions
        class="new-user__form__container"
        direction="vertical"
        :column="4"
        border
      >
        <el-descriptions-item :span="4" label="Name">
          <el-form-item prop="name">
            <el-input v-model="user.name"> </el-input>
          </el-form-item>
        </el-descriptions-item>
        <el-descriptions-item
          label="Email"
          :span="ScreenWidth < 992 ? 4 : role === 'agent' ? 1 : 2"
        >
          <el-form-item prop="email">
            <el-input v-model="user.email"> </el-input>
          </el-form-item>
        </el-descriptions-item>
        <el-descriptions-item
          label="Phone Number"
          :span="ScreenWidth < 992 ? 4 : 2"
        >
          <el-form-item>
            <el-input v-model="user.phone_number"> </el-input>
          </el-form-item>
        </el-descriptions-item>
        <el-descriptions-item
          v-if="role === 'agent'"
          :span="ScreenWidth < 992 ? 4 : 1"
          label="Agent Registration Number"
        >
          <el-form-item>
            <el-input v-model="user.agent_registration_number"> </el-input>
          </el-form-item>
        </el-descriptions-item>
        <el-descriptions-item label="Bio" :span="4">
          <el-form-item>
            <el-input type="textarea" v-model="user.bio"> </el-input>
          </el-form-item>
        </el-descriptions-item>
      </el-descriptions>
      <el-button
        class="new-user__form__container__button"
        @click="handleCreateUser"
        :loading="creatingUser"
      >
        Create New
        {{ capitalize(role) }}
      </el-button>
    </el-form>
    <div v-else>This Feature is coming soon</div>
  </el-container>
</template>

<script lang="ts">
import { defineComponent, ref, toRefs, watchEffect } from "vue";
import { useRouter } from "vue-router";
import { capitalize } from "@/Helpers";
import { manageNewUser } from "@/composables/Users/NewUser";
import GetError, { ResponseError } from "@/Helpers/GetError";
import { ElMessage, ElNotification } from "element-plus";
import ScreenWidth from "@/Helpers/GetScreenWidth";

export default defineComponent({
  props: {
    role: {
      type: String,
      required: true,
    },
  },
  setup(props) {
    const router = useRouter();
    const { role } = toRefs(props);
    const errors = ref();
    //TODO {Thendo} :Error Types
    const validationErrors = ref<any[]>([]);
    const userCreationForm = ref();
    const {
      user,
      userValidator,
      creatingUser,
      createUser,
      processRole,
      getEmptyUser,
    } = manageNewUser();
    const loading = ref(false);
    const validForm = ref(true);

    watchEffect(() => {
      if (
        role.value &&
        !["admin", "tenant", "agent"].includes(role.value.toLowerCase())
      ) {
        router.push("/dashboard/not_found");
        role.value = role.value.toLowerCase();
      }
      // loading.value = (role.value && true) || false;
    });

    async function handleCreateUser() {
      userCreationForm.value.validate((valid: boolean) => {
        validForm.value = valid;
      });
      Object.assign(user, processRole(role.value));
      if (validForm.value) {
        try {
          if (await createUser(user)) {
            ElNotification({
              message: "User created",
              type: "success",
            });
            Object.assign(user, getEmptyUser());
          }
        } catch (error) {
          errors.value = GetError(error as ResponseError);
          validationErrors.value = [];
          if (errors.value.validationError !== "API Error, please try again.") {
            for (const key in errors.value) {
              if (Object.prototype.hasOwnProperty.call(errors.value, key)) {
                validationErrors.value.push(...errors.value[key]);
              }
            }
          }
          for (let index = 0; index < validationErrors.value.length; index++) {
            const validationError = validationErrors.value[index];
            ElMessage({
              showClose: true,
              type: "error",
              message: validationError,
            });
          }
          //TODO {Thendo}: Add server error
        }
      }
      return;
    }

    return {
      user,
      capitalize,
      errors,
      loading,
      ScreenWidth,
      handleCreateUser,
      userValidator,
      creatingUser,
      userCreationForm,
      validForm,
      validationErrors,
    };
  },
});
</script>

<style lang="scss" scoped>
.el-container {
  flex-flow: column nowrap;
}
.el-row {
  flex-flow: row nowrap;
  margin-top: 1rem;
}
.new-user {
  display: flex;
  align-items: center;
  flex-direction: column;
  height: 100%;
  &__form {
    width: 100vw;
    padding: 1rem;
    box-shadow: none;
    @media (min-width: 601px) {
      box-shadow: 1px 1px 10px 0px #e6a23c, -1px -1px 10px 0px #e6a23c;
      width: 80vw;
    }
    &__container {
      &__button {
        margin: 1rem 0;
      }
    }
  }
}
</style>

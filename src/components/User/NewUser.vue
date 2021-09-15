<template>
  <el-container class="new-user">
    <el-form v-if="role" class="new-user__form">
      <h1>
        Add New
        {{ `${capitalize(role)}${role.toLowerCase() === "tenant" ? "s" : ""}` }}
      </h1>
      <el-container v-for="(user, i) in newUsers" :key="i">
        <el-alert
          title="Invalid Credential"
          type="error"
          show-icon
          v-for="(error, i) in user.error?.email"
          :key="i"
        >
          {{ error }}
        </el-alert>
        <el-row>
          <el-form-item class="new-user__form__email">
            <el-input
              type="email"
              :required="true"
              :placeholder="`New ${capitalize(role)} Email`"
              v-model="user.email"
            ></el-input>
          </el-form-item>
          <el-form-item
            v-if="role.toLowerCase() === 'tenant'"
            class="new-user__form__new-user-form"
          >
            <el-button
              :id="`${i}`"
              @click="i == 0 ? addUser(i) : newUsers.pop()"
              :icon="i == 0 ? 'el-icon-plus' : 'el-icon-minus'"
              circle
            ></el-button>
          </el-form-item>
        </el-row>
      </el-container>
      <el-button @click="createUsers">
        Create New
        {{ `${capitalize(role)}${role.toLowerCase() === "tenant" ? "s" : ""}` }}
      </el-button>
    </el-form>
  </el-container>
</template>

<script lang="ts">
import { defineComponent, toRefs, watchEffect } from "vue";
import { useRouter } from "vue-router";
import { capitalize } from "@/Helpers";
import { manageNewUser } from "@/composables/Users/NewUser";
import GetError from "@/Helpers/GetError";

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
    const { clearNewUsers, newUsers, addUser, createNewUsers } =
      manageNewUser();

    watchEffect(() => {
      if (
        role.value &&
        !["admin", "tenant", "agent"].find(
          (currentRole) => currentRole === role.value.toLowerCase()
        )
      ) {
        router.push("/dashboard/not_found");
      }
      if (role.value.toLowerCase() !== "tenant") {
        clearNewUsers();
      }
    });

    async function createUsers() {
      try {
        await createNewUsers(role.value);
      } catch (error) {
        GetError;
      }
    }

    return {
      newUsers,
      capitalize,
      addUser,
      createUsers,
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
    @media (min-width: 769px) {
      width: 50vw;
    }
    &__email {
      width: 100%;
    }
    &__new-user-form {
      margin-left: 1rem;
    }
  }
}
</style>

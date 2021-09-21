<template>
  <div class="role-tags">
    <el-tag
      v-if="userRoles.is_admin"
      effect="dark"
      type="success"
      size="small"
      :closable="editing && Auth.IsAdmin()"
      @close="handleToggleAdmin"
    >
      Admin
    </el-tag>
    <el-tag
      v-if="userRoles.is_agent"
      effect="dark"
      type="warning"
      size="small"
      :closable="editing && Auth.IsAdmin()"
      @close="handleToggleAgent"
    >
      Agent
    </el-tag>
    <el-tag
      v-if="userRoles.is_tenant"
      effect="dark"
      type="info"
      size="small"
      :closable="editing"
      @close="handleToggleTenant"
    >
      Tenant
    </el-tag>
    <el-popover
      v-if="editing"
      :placement="screenWidth > 767 ? 'right' : 'bottom'"
      :width="400"
      trigger="click"
    >
      <template
        #reference
        v-if="
          (editing &&
            !(
              userRoles.is_agent &&
              userRoles.is_admin &&
              userRoles.is_tenant
            )) ||
          Auth.IsAdmin()
        "
      >
        <el-button icon="el-icon-plus" circle size="mini"></el-button>
      </template>
      <div class="role-tags__new-role-buttons">
        <el-button
          v-if="!userRoles.is_admin && Auth.IsAdmin()"
          type="success"
          size="mini"
          class="role-tags__new-role-buttons__button"
          @click="handleToggleAdmin"
          >Admin</el-button
        >
        <el-button
          v-if="!userRoles.is_agent && Auth.IsAdmin()"
          type="warning"
          size="mini"
          class="role-tags__new-role-buttons__button"
          @click="handleToggleAgent"
          >Agent</el-button
        >
        <el-button
          v-if="!userRoles.is_tenant && (Auth.IsAdmin() || Auth.IsAgent())"
          type="info"
          size="mini"
          class="role-tags__new-role-buttons__button"
          @click="handleToggleTenant"
          >Tenant</el-button
        >
      </div>
    </el-popover>
  </div>
  <el-avatar class="avatar" shape="square" :size="200" :src="user.photo">
  </el-avatar>
</template>
<script lang="ts">
import { IUserDataType } from "@/store/auth";
import { defineComponent, PropType, reactive, ref, toRefs, watch } from "vue";
import Auth from "@/store/auth";
import { IUserRoles } from "@/interfaces/User";

export default defineComponent({
  props: {
    user: {
      type: Object as PropType<IUserDataType>,
      required: true,
    },
    editing: {
      type: Boolean,
      required: true,
    },
    screenWidth: {
      type: Number,
      required: true,
    },
  },
  emits: {
    userAvatarEdited: (userRoles: IUserRoles) => (userRoles && true) || false,
  },
  setup(props, { emit }) {
    const { user: userProp } = toRefs(props);
    const userRoles = reactive<IUserRoles>({ ...userProp.value });
    const selectNewRole = ref(false);
    watch(userRoles, (newUserRoles) => {
      emit("userAvatarEdited", newUserRoles);
    });
    function handleToggleAgent() {
      userRoles.is_agent = !userRoles.is_agent;
    }
    function handleToggleTenant() {
      userRoles.is_tenant = !userRoles.is_tenant;
    }
    function handleToggleAdmin() {
      userRoles.is_agent = !userRoles.is_admin;
    }
    Auth;
    return {
      userRoles,
      selectNewRole,
      Auth: Auth(),
      handleToggleAdmin,
      handleToggleAgent,
      handleToggleTenant,
    };
  },
});
</script>
<style lang="scss" scoped>
.role-tags {
  margin-bottom: 1rem;
  .el-tag {
    margin-right: 0.25rem;
    margin-bottom: 0.25rem;
  }
  &__new-role-buttons {
    display: flex;
    flex-flow: column nowrap;
    width: 100%;
    padding: 0 1rem;
    &__button {
      margin: 0.5rem;
    }
  }
}
.avatar {
  @media (min-width: 992px) {
    flex-flow: row nowrap;
    width: 70%;
  }
}
</style>

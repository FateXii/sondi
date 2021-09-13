<template>
  <el-container v-loading="loading">
    <h2>{{ user.name }}</h2>
    <div class="user-list__item">
      <div class="user-list__item__summary">
        <user-avatar
          :editing="editing"
          :user="user"
          @userAvatarEdited="handleAvatarEdited"
          :screenWidth="ScreenWidth"
        />
        <el-button-group class="user-list__item__summary__buttons">
          <el-button
            type="primary"
            icon="el-icon-edit"
            @click="toggleEditing"
            circle
          ></el-button>
          <el-button
            v-if="ScreenWidth <= 992"
            type="success"
            @click="toggleInfo()"
            icon="el-icon-info"
            circle
          ></el-button>
          <el-popconfirm
            confirmButtonText="Yes"
            cancelButtonText="No"
            icon="el-icon-info"
            iconColor="red"
            title="Are you sure to delete this?"
            @confirm="handleDeleteUser"
            v-if="
              Auth.IsAdmin() ||
              (Auth.IsAgent && user.is_tenant && !user.is_agent)
            "
          >
            <template #reference>
              <el-button type="danger" icon="el-icon-delete" circle></el-button>
            </template>
          </el-popconfirm>
        </el-button-group>
      </div>
      <div class="user-list__item__description">
        <el-collapse-transition>
          <div class="user-list__item__description__container">
            <user-item-description
              :user="user"
              :screenWidth="ScreenWidth"
              :editing="editing"
              v-if="showInfo || ScreenWidth >= 992"
              @userEdited="handleUserDescriptionEdited"
            />
            <el-button-group
              v-if="editing"
              class="user-list__item__description__container__buttons"
            >
              <el-popconfirm
                confirmButtonText="Yes"
                cancelButtonText="No"
                icon="el-icon-info"
                iconColor="red"
                title="Are you sure to edit this?"
                @confirm="handleEditUser"
              >
                <template #reference>
                  <el-button type="success"> Submit Changes </el-button>
                </template>
              </el-popconfirm>
              <el-button type="info" @click="editing = false">Cancel</el-button>
            </el-button-group>
          </div>
        </el-collapse-transition>
      </div>
      <el-button
        class="user-list__item__info-hide-button"
        type="primary"
        v-if="showInfo && ScreenWidth < 760"
        @click="toggleInfo()"
        icon="el-icon-arrow-up"
        circle
      ></el-button>
    </div>
  </el-container>
</template>

<script lang="ts">
import GetError, { ResponseError } from "@/Helpers/GetError";
import UsersService from "@/services/UsersService";
import useAuthStore, { IUserDataType } from "@/store/auth";
import { ElMessage, ElMessageBox, ElNotification } from "element-plus";
import {
  defineComponent,
  onUpdated,
  PropType,
  reactive,
  ref,
  toRefs,
} from "vue";
import ScreenWidth from "@/Helpers/GetScreenWidth";
import UserItemDescription, {
  IAbreviatedUser,
} from "./UserItemDescription.vue";
import UserAvatar, { IUserRoles } from "./UserAvatar.vue";

export default defineComponent({
  components: { UserItemDescription, UserAvatar },
  props: {
    user: {
      type: Object as PropType<IUserDataType>,
      required: true,
    },
  },
  emits: {
    onDeleted: (id: number) => {
      return (id && true) || false;
    },
    onUpdated: (id: number) => {
      return (id && true) || false;
    },
  },
  setup(props, { emit }) {
    const { user } = toRefs(props);
    const Auth = useAuthStore();
    const showInfo = ref(false);
    const loading = ref(false);
    function toggleInfo() {
      showInfo.value = !showInfo.value;
    }
    function handleDeleteUser() {
      loading.value = true;
      ElMessageBox.confirm &&
        ElMessageBox.confirm(
          "This users data will be deleted are you sure you would like to continue?",
          "Warning",
          {
            confirmButtonText: "Delete",
            cancelButtonText: "Cancel",
            type: "warning",
            center: true,
          }
        ).then(() => {
          UsersService.delete(user.value.id)
            .then(() => {
              ElMessage &&
                ElMessage({
                  message: `User ${user.value.name} deleted`,
                  type: "success",
                });
              loading.value = false;
              emit("onDeleted", user.value.id);
            })
            .catch((error) => {
              console.log(GetError(error as ResponseError));
              loading.value = false;
            });
        });
    }
    const editing = ref(false);
    const editableUserData = reactive({
      agent_registration_number: user.value.agent_registration_number,
      is_admin: user.value.is_admin,
      is_agent: user.value.is_agent,
      is_tenant: user.value.is_tenant,
      bio: user.value.bio,
      phone_number: user.value.phone_number,
      email: user.value.email,
    });
    function handleUserDescriptionEdited(editedUserData: IAbreviatedUser) {
      Object.assign(editableUserData, editedUserData);
    }
    function handleAvatarEdited(userRoles: IUserRoles) {
      Object.assign(editableUserData, userRoles);
    }
    function toggleEditing() {
      editing.value = !editing.value;
      toggleInfo();
    }
    function diff() {
      let dataMap = new Map(Object.entries(editableUserData));
      Object.entries(user.value).forEach(([key, value]) => {
        if (dataMap.has(key)) {
          if (dataMap.get(key) === value) {
            dataMap.delete(key);
          }
        }
      });
      return Object.fromEntries(dataMap.entries());
    }
    function handleEditUser() {
      loading.value = true;
      UsersService.update(user.value.id, diff())
        .then(() => {
          ElNotification.success &&
            ElNotification.success({
              title: "Updated",
              message: `User ${user.value.name} Updated`,
            });

          loading.value = false;
          editing.value = false;
          emit("onUpdated", user.value.id);
        })
        .catch((error) => {
          console.log(GetError(error as ResponseError));
          loading.value = false;
        });
    }

    return {
      Auth,
      showInfo,
      toggleInfo,
      toggleEditing,
      ScreenWidth,

      editableUserData,
      editing,
      loading,
      handleUserDescriptionEdited,
      handleAvatarEdited,
      handleDeleteUser,
      handleEditUser,
    };
  },
});
</script>
<style lang="scss" scoped>
.el-tag {
  margin-right: 0.25rem;
}
.el-container {
  flex-flow: column nowrap;
  width: 100%;
  h2 {
    align-self: center;
  }
}
.user-list__item {
  display: flex;
  flex-flow: column nowrap;
  align-items: center;
  justify-content: center;
  @media (min-width: 992px) {
    flex-flow: row nowrap;
    justify-content: flex-start;
  }
  &__summary {
    display: flex;
    flex-flow: column nowrap;
    align-items: center;
    @media (min-width: 992px) {
      margin-right: 1rem;
    }
    &__buttons {
      margin: 1rem 0;
    }
  }
  &__description {
    width: 100%;
    &__container {
      &__buttons {
        margin-top: 1rem;
      }
    }
  }
  &__info-hide-button {
    margin: 1rem 0;
  }
}
</style>

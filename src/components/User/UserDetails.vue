<template>
  <el-container v-if="user" v-loading="pageLoading && user">
    <h2>{{ user && user.name }}</h2>
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
          <el-popconfirm
            confirmButtonText="Yes"
            cancelButtonText="No"
            icon="el-icon-info"
            iconColor="red"
            title="Are you sure to delete this?"
            @confirm="handleDeleteUser"
            v-if="
              Auth.IsAdmin() ||
              (Auth.IsAgent() && user && user.is_tenant && !user.is_agent)
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
    </div>
  </el-container>
</template>

<script lang="ts">
import GetError, { ResponseError } from "@/Helpers/GetError";
import UsersService from "@/services/UsersService";
import useAuthStore, { IUserDataType } from "@/store/auth";
import { ElMessage, ElMessageBox, ElNotification } from "element-plus";
import {
  computed,
  defineComponent,
  onMounted,
  reactive,
  ref,
  toRefs,
} from "vue";
import ScreenWidth from "@/Helpers/GetScreenWidth";
import UserItemDescription, {
  IAbreviatedUser,
} from "./UserItemDescription.vue";
import UserAvatar from "./UserAvatar.vue";
import { useRouter } from "vue-router";
import { IUserRoles } from "@/interfaces/User";
import { ManageUsers } from "@/composables/Users/ManageUsers";

type NotificationType = "success" | "warning" | "info" | "error" | "";
export default defineComponent({
  components: { UserItemDescription, UserAvatar },
  props: {
    id: {
      type: String,
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
    const { id } = toRefs(props);
    const numId = computed(() => Number(id.value));
    const router = useRouter();
    const Auth = useAuthStore();
    const userLoading = computed(() => user.value || false);
    const {
      pageLoading,
      toggleEditing,
      deleteUser,
      updateUser,
      handleAvatarEdited,
      handleUserDescriptionEdited,
      editableUserData,
      diff,
      editing,
      user,
    } = ManageUsers();

    function showNotification(message: string, type: NotificationType) {
      ElNotification({ message, type });
    }
    async function warnConfirm(message: string, type: NotificationType) {
      ElMessageBox.confirm &&
        ElMessageBox.confirm(message, type, {
          confirmButtonText: "Delete",
          cancelButtonText: "Cancel",
          type,
          center: true,
        });
    }
    onMounted(async () => {
      try {
        const response = await UsersService.get(numId.value);
        const data = response.data;
        user.value = data.data;
        Object.assign(editableUserData, user.value);
      } catch (error) {
        GetError(error as ResponseError);
      }
    });
    function handleDeleteUser() {
      pageLoading.value = true;
      warnConfirm(
        "This users data will be deleted are you sure you would like to continue?",
        "warning"
      ).then(() => {
        deleteUser(numId.value)
          .then((isDeleted) => {
            if (isDeleted) {
              showNotification(
                `User ${user.value && user.value.name} deleted`,
                "success"
              );
              pageLoading.value = false;
              router.push("/dashboard/users");
            }
          })
          .catch((error) => {
            console.log(GetError(error as ResponseError));
            pageLoading.value = false;
          });
      });
    }
    function handleEditUser() {
      pageLoading.value = true;
      updateUser(numId.value, diff(editableUserData, user.value && user.value))
        .then((isUpdated) => {
          if (isUpdated) {
            showNotification(
              `User ${user.value && user.value.name} Updated`,
              "success"
            );
            pageLoading.value = false;
            editing.value = false;
          }
        })
        .catch((error) => {
          GetError(error as ResponseError);
          pageLoading.value = false;
        });
    }

    return {
      Auth,
      toggleEditing,
      ScreenWidth,
      user,

      editableUserData,
      editing,
      pageLoading,
      userLoading,
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

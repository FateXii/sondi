<template>
  <el-container v-loading="loading">
    <h2>{{ user.name }}</h2>
    <div class="user-list__item">
      <div class="user-list__item__summary">
        <router-link :to="`/dashboard/users/${user.id}`">
          <user-avatar
            :editing="editing"
            :user="user"
            :screenWidth="ScreenWidth"
          />
        </router-link>
        <el-button-group class="user-list__item__summary__buttons">
          <el-button
            type="success"
            @click="viewInfo()"
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
              (Auth.IsAgent() && user.is_tenant && !user.is_agent)
            "
          >
            <template #reference>
              <el-button type="danger" icon="el-icon-delete" circle></el-button>
            </template>
          </el-popconfirm>
        </el-button-group>
      </div>
    </div>
  </el-container>
</template>

<script lang="ts">
import GetError, { ResponseError } from "@/Helpers/GetError";
import UsersService from "@/services/UsersService";
import useAuthStore, { IUserDataType } from "@/store/auth";
import { ElMessage, ElMessageBox } from "element-plus";
import { defineComponent, PropType, ref, toRefs } from "vue";
import ScreenWidth from "@/Helpers/GetScreenWidth";
import UserAvatar from "./UserAvatar.vue";
import { useRouter } from "vue-router";

export default defineComponent({
  components: { UserAvatar },
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
    const router = useRouter();
    const loading = ref(false);
    function viewInfo() {
      router.push(`/dashboard/users/${user.value.id}`);
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

    return {
      Auth,
      editing: false,
      ScreenWidth,
      loading,
      viewInfo,
      handleDeleteUser,
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

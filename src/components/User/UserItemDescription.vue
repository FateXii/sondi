<template>
  <el-descriptions direction="vertical" :column="4" border>
    <el-descriptions-item :span="4" label="Name">
      {{ user.name }}
    </el-descriptions-item>
    <el-descriptions-item
      label="Phone Number"
      :span="screenWidth < 992 ? 4 : 1"
    >
      <el-input v-if="editing" v-model="editableUserData.phone_number">
      </el-input>
      <span v-else>
        {{ user.phone_number }}
      </span>
    </el-descriptions-item>
    <el-descriptions-item label="Email" :span="screenWidth < 992 ? 4 : 1">
      <el-input v-if="editing" v-model="editableUserData.email"> </el-input>
      <span v-else>
        {{ user.email }}
      </span>
    </el-descriptions-item>
    <el-descriptions-item
      :span="screenWidth < 992 ? 4 : 2"
      v-if="user.is_agent"
      label="Agent Registration Number"
    >
      <el-input
        v-if="editing"
        v-model="editableUserData.agent_registration_number"
      >
      </el-input>
      <span v-else>
        {{ user.agent_registration_number }}
      </span>
    </el-descriptions-item>
    <el-descriptions-item label="Bio" :span="4">
      <el-input type="textarea" v-if="editing" v-model="editableUserData.bio">
      </el-input>
      <span v-else>
        {{ user.bio }}
      </span>
    </el-descriptions-item>
  </el-descriptions>
</template>

<script lang="ts">
import { IUserDataType } from "@/store/auth";
import { defineComponent, PropType, reactive, toRef, toRefs, watch } from "vue";

export interface IAbreviatedUser {
  is_agent: boolean;
  phone_number: string;
  agent_registration_number: string;
  bio: string;
  name: string;
  email: string;
}

export default defineComponent({
  props: {
    user: {
      type: Object as PropType<IUserDataType>,
      required: true,
    },
    screenWidth: {
      type: Number,
      required: true,
    },
    editing: {
      type: Boolean,
      required: true,
    },
  },
  emits: {
    userEdited: (userData: IAbreviatedUser) => (userData && true) || false,
  },
  setup(props, { emit }) {
    const { user: userData } = toRefs(props);
    const editableUserData = reactive({ ...userData.value });
    watch(editableUserData, (newUserData) => {
      emit("userEdited", newUserData);
    });
    return {
      editableUserData,
    };
  },
});
</script>
<style lang="scss" scoped>
.el-description {
  width: stretch;
}
</style>

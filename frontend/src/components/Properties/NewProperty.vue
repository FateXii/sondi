<template>
  <div class="property">
    <el-form label-position="top" @submit="createNewProperty">
      <div class="property__heading property-item">
        <el-form-item label="Title">
          <el-input v-model="propertyTitle" />
        </el-form-item>
        <el-form-item label="Cover Image">
          <single-image-upload @onImageChange="handleCoverImageChange" />
        </el-form-item>
        <el-form-item label="Youtube Video">
          <el-input v-model="propertyForm.video_url" />
        </el-form-item>
      </div>
      <div class="property__images property-item">
        <el-form-item label="Image List">
          <multi-image-upload @uploadedImagesChange="handleImageListChange" />
        </el-form-item>
      </div>
      <div class="property__description property-item">
        <property-description-form
          @descriptionFormChange="handleDescriptionFormChange"
        />
      </div>
      <div class="property__features property-item">
        <el-form-item label="Features">
          <property-feature-list @newFeatures="handleFeatureChange" />
        </el-form-item>
      </div>
      <div class="property__agents property-item">
        <agents @agentListChange="handleAgentListChange" />
      </div>
      <el-form-item>
        <el-button @click="createNewProperty">Create Property</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, reactive, ref } from "vue";
import GetScreenWidth from "@/Helpers/GetScreenWidth";
import SingleImageUpload from "@/components/Properties/NewProperty/SingleImageUpload.vue";
import PropertyFeatureList from "./NewProperty/PropertyFeatures/PropertyFeatureList.vue";
import PropertyDescriptionForm from "./NewProperty/PropertyDescriptionForm.vue";
import { titleCase } from "@/Helpers";
import MultiImageUpload from "./NewProperty/MultiImageUpload.vue";
import { IAgent, IPropertyFeature } from "@/Types/Property";
import { List } from "@/Types";
import PropertyService from "@/services/PropertyService";
import GetError, { ResponseError } from "@/Helpers/GetError";
import Agents from "./NewProperty/Agents.vue";
import { IPropertyDescriptionForm } from "@/Types/Forms";
import { UploadFile } from "element-plus/lib/components/upload/src/upload.type";
import { useRouter } from "vue-router";

const currencyFormatter = new Intl.NumberFormat("en-ZA", {
  currency: "ZAR",
  style: "currency",
});

export default defineComponent({
  components: {
    SingleImageUpload,
    PropertyDescriptionForm,
    PropertyFeatureList,
    MultiImageUpload,
    Agents,
  },
  methods: {
    titleCase,
  },
  setup() {
    //TODO {Thendo} : Handle new feature creation api calls and composition
    const propertyTitle = ref("");
    const agents = reactive<List<IAgent>>({ list: [] });
    const selectedAgents = reactive<List<number>>({ list: [] });
    interface INewPropertyForm {
      cover_image: UploadFile;
      image_list: UploadFile[];
      agent_list: number[];
      video_url: string;
      property_description: IPropertyDescriptionForm;
      property_features: IPropertyFeature[];
    }
    const propertyForm = reactive<INewPropertyForm>(
      Object() as INewPropertyForm
    );
    const router = useRouter();

    function createPropertyPayload(propertyForm: INewPropertyForm): FormData {
      const form = new FormData();
      form.append("cover_image", propertyForm.cover_image.raw);
      for (let index = 0; index < propertyForm.agent_list.length; index++) {
        const agent = propertyForm.agent_list[index];
        form.append("agents[]", agent.toString());
      }
      for (let index = 0; index < propertyForm.image_list.length; index++) {
        const image = propertyForm.image_list[index];
        form.append("images[]", image.raw);
      }
      form.append(
        "street",
        propertyForm.property_description.address.address.street
      );
      form.append(
        "province",
        propertyForm.property_description.address.address.province
      );
      form.append(
        "postal_code",
        propertyForm.property_description.address.address.postal_code
      );
      form.append(
        "city",
        propertyForm.property_description.address.address.city
      );

      form.append("price", propertyForm.property_description.price.toString());
      form.append(
        "is_rental",
        propertyForm.property_description.is_rental ? "1" : "0"
      );

      form.append("video_url", propertyForm.video_url);
      form.append(
        "is_sectional",
        propertyForm.property_description.address.isSectional ? "1" : "0"
      );
      form.append(
        "sectional_id",
        propertyForm.property_description.address.sectionalId.toString()
      );
      form.append(
        "unit",
        propertyForm.property_description.address.address.unit?.toString() || ""
      );
      form.append("title", propertyForm.property_description.title);
      form.append(
        "description_title",
        propertyForm.property_description.description.heading
      );
      form.append(
        "description",
        propertyForm.property_description.description.text
      );
      form.append("features", JSON.stringify(propertyForm.property_features));
      return form;
    }

    onMounted(async () => {
      try {
        const { data: responseData } = await PropertyService.getAgents();
        agents.list = responseData.data;
      } catch (e) {
        GetError(e as ResponseError);
      }
    });
    const editing = ref(true);
    function handleCoverImageChange(cover_image: UploadFile) {
      Object.assign(propertyForm, { cover_image });
      // console.log(image);
    }
    function handleAgentListChange(agent_list: number[]) {
      Object.assign(propertyForm, { agent_list });
      // console.log(list);
    }
    function handleImageListChange(image_list: UploadFile[]) {
      Object.assign(propertyForm, { image_list });
    }
    function handleDescriptionFormChange(
      property_description: IPropertyDescriptionForm
    ) {
      Object.assign(propertyForm, { property_description });
    }
    function handleFeatureChange(property_features: IPropertyFeature[]) {
      Object.assign(propertyForm, { property_features });
    }

    function createNewProperty() {
      PropertyService.create(createPropertyPayload(propertyForm))
        .then((response) => {
          const id = response.data.id;
          router.push(`/dashboard/properties/${id}`);
        })
        .catch((e) => GetError(e as ResponseError));
      // return;
    }

    return {
      currencyFormatter,
      GetScreenWidth,
      editing,
      handleCoverImageChange,
      handleAgentListChange,
      handleImageListChange,
      handleDescriptionFormChange,
      handleFeatureChange,
      createNewProperty,
      propertyForm,
      agents,
      selectedAgents,
      propertyTitle,
    };
  },
});
</script>

<style lang="scss" scoped>
.property-item {
  border: 0.5px solid rgba($color: #888, $alpha: 0.5);
  margin-bottom: 2rem;
  padding: 1.75rem;
}

.property {
  height: fit-content;
  flex: 2;
  &__agents {
    &__item {
      &__details {
      }
    }
  }
  &__heading {
  }
  &__description {
  }
  &__images {
    &__image {
    }
  }
}
</style>

<script setup>
import {onMounted, ref} from "vue";
import {useRoute} from "vue-router";
import {VTextField, VSelect} from "vuetify/components";

const props = defineProps({
  itemMaterials: {
    type: Array,
    default: () => []
  },

  rules: {
    type: Object,
    default: () => ({})
  }
});

const fields = ref([]);
const formValues = defineModel();
const nameForm = ref("");

const route = useRoute();
const path = route.path;

const getFieldComponent = (field) => {
  if (field.name_field === "id_material") {
    return VSelect;
  }

  switch (field.type_field) {
    case "select":
      return VSelect;

    case "text":
    case "email":
    case "tel":
    case "number":
    default:
      return VTextField;
  }
};

const getFieldProps = (field) => {
  if (field.name_field === "id_material") {
    return {
      items: props.itemMaterials,
      "item-title": "name",
      "item-value": "id",
      label: field.title_field,
      clearable: true
    };
  }

  switch (field.type_field) {
    case "email":
      return {
        type: "email"
      };

    case "tel":
      return {
        type: "tel"
      };

    case "number":
      return {
        type: "number"
      };

    default:
      return {};
  }
};

const getFieldRules = (field) => {
  const rules = [];

  if (field.is_required && props.rules.required) {
    rules.push(props.rules.required);
  }

  if (field.type_field === "email" && props.rules.email) {
    rules.push(props.rules.email);
  }

  return rules;
};

const getFormFields = async () => {
  const response = await fetch("/api/forms/getFields", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({
      route: path
    })
  });

  const data = await response.json();

  nameForm.value = data.form_name;

  formValues.value.module_id = data.module_id;
  formValues.value.form_id = data.id;

  fields.value = [
    ...data.fields,
    ...data.custom_fields
  ];

  fields.value.forEach((field) => {
    formValues.value[field.name_field] = null;
  });
};

onMounted(() => {
  getFormFields();
});
</script>

<template>
  <div class="request_form">
    <v-card-title>
      {{ nameForm }}
    </v-card-title>

    <input
        type="hidden"
        name="module_id"
        v-model="formValues.module_id"
    >

    <input
        type="hidden"
        name="form_id"
        v-model="formValues.form_id"
    >

    <component
        v-for="field in fields"
        :key="field.id"
        :is="getFieldComponent(field)"
        v-model="formValues[field.name_field]"
        :rules="getFieldRules(field)"
        v-bind="getFieldProps(field)"
    >
      <template #label>
        {{ field.title_field }}

        <span
            v-if="field.is_required"
            class="required"
        >
          *
        </span>
      </template>
    </component>
  </div>
</template>

<style scoped>
.required {
  color: red;
  margin-left: 3px;
}
</style>
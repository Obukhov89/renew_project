<script setup>
import {onMounted, ref} from "vue";
import {useRoute} from "vue-router";
import {VTextField, VSelect} from "vuetify/components";

const fields = ref([]);
const formValues = ref({});
const nameForm = ref("");

const route = useRoute();
const path = route.path;

const getFieldComponent = (field) => {
  switch (field.type_field) {
    case "select":
      return VSelect;

    case "text":
    case "email":
    case "tel":
    case "number":
      return VTextField;

    default:
      return VTextField;
  }
};

const getFieldProps = (field) => {
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

  fields.value = [
    ...data.fields,
    ...data.custom_fields
  ];

  fields.value.forEach(field => {
    formValues.value[field.name_field] = null;
  });
};

onMounted(() => {
  getFormFields();
});
</script>

<template>
  <div class="request_form">
    <v-card-title>{{ nameForm }}</v-card-title>

    <v-form>
      <component
          v-for="field in fields"
          :key="field.id"
          :is="getFieldComponent(field)"
          v-model="formValues[field.name_field]"
          :label="field.title_field"
          v-bind="getFieldProps(field)"
      />

      <v-btn type="submit">
        Сохранить
      </v-btn>
    </v-form>
  </div>
</template>
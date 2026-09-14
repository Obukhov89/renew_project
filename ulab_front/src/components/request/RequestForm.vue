<template>
  <div class="request_form">
    <v-form ref="requestForm" @submit.prevent="saveRequest">
      <DynamicForm v-model="form" :item-materials="itemMaterials" :rules="rules"/>
      <v-col cols="auto">
        <v-btn type="submit" color="primary"> Сохранить</v-btn>
      </v-col>
    </v-form>
  </div>
</template>

<script setup>
import {ref} from "vue";
import {showNotification} from "/app/src/utils/notification.js";
import DynamicForm from "/app/src/components/forms/DynamicForm.vue";

const requestForm = ref(null);

const rules = {
  required: (value) => {
    return !!value || "Поле обязательно для заполнения";
  },

  email: (value) => {
    return (
        !value ||
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value) ||
        "Введите корректный E-mail"
    );
  },
};

const itemMaterials = [
  {id: 1, name: "Материал 1"},
  {id: 2, name: "Материал 2"},
  {id: 3, name: "Материал 3"},
  {id: 4, name: "Материал 4"},
];

const form = ref({});

const saveRequest = async () => {
  console.log(form.value);
  const {valid} = await requestForm.value.validate();

  if (!valid) {
    showNotification(
        "warning",
        "Проверьте форму",
        "Заполните обязательные поля"
    );

    return;
  }

  try {
    const response = await fetch("/api/saveRequest", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(form.value),
    });

    const data = await response.json();

    if (!response.ok) {
      throw new Error(data.message || "Ошибка сохранения заявки");
    }

    showNotification("success", "Заявка сохранена", data.message);
  } catch (error) {
    console.error(error);

    showNotification(
        "error",
        "Ошибка",
        error.message || "Не удалось сохранить заявку"
    );
  }
};
</script>
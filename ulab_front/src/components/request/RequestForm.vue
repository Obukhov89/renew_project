<template>
  <div class="request_form">
    <v-card-title> Заявка на испытания </v-card-title>

    <v-form ref="requestForm" @submit.prevent="saveRequest">
      <v-select
        v-model="form.id_material"
        name="material_id"
        :items="itemMaterials"
        item-title="name"
        item-value="id"
        label="Выберите материал"
        :rules="[rules.required]"
      />

      <v-text-field
        v-model="form.customer"
        name="customer"
        label="Заказчик"
        :rules="[rules.required]"
      />

      <v-text-field
        v-model="form.email"
        name="email"
        label="E-mail"
        :rules="[rules.required, rules.email]"
      />

      <v-text-field
        v-model="form.phone"
        name="phone"
        label="Телефон"
        :rules="[rules.required]"
      />

      <v-text-field
        v-model="form.contact_person"
        name="contact_person"
        label="Контактное лицо"
        :rules="[rules.required]"
      />

      <v-text-field
        v-model="form.batch_number"
        name="batch_number"
        label="Номер партии"
      />

      <v-text-field
        v-model="form.basis_contest"
        name="basis_contest"
        label="Основание для испытаний"
      />

      <v-text-field
        v-model="form.count_probes"
        name="count_probes"
        label="Количество проб в партии"
        :rules="[rules.required]"
      />

      <v-col cols="auto">
        <v-btn type="submit" color="primary"> Сохранить </v-btn>
      </v-col>
    </v-form>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { showNotification } from "/app/src/utils/notification.js";

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
  { id: 1, name: "Материал 1" },
  { id: 2, name: "Материал 2" },
  { id: 3, name: "Материал 3" },
  { id: 4, name: "Материал 4" },
];

const form = ref({
  id_material: null,
  customer: "",
  email: "",
  phone: "",
  contact_person: "",
  batch_number: "",
  basis_contest: "",
  count_probes: "",
});

const saveRequest = async () => {
  const { valid } = await requestForm.value.validate();

  if (!valid) {
    showNotification(
      "warning",
      "Проверьте форму",
      "Заполните обязательные поля"
    );

    return;
  }

  const saveRequest = async () => {
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
};
</script>
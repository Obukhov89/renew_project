```vue
<script setup>
import {ref} from 'vue';

const addNewRoom = ref(false);
const roomForm = ref({
  department: '',
  responsible: '',
  name: '',
  number: '',
  type: '',
  address: '',
});

const showNewRoom = () => {
  addNewRoom.value = true;
};

const resetForm = () => {
  roomForm.value = {
    department: '',
    responsible: '',
    name: '',
    number: '',
    type: '',
    address: '',
  };
};

const closeModal = () => {
  addNewRoom.value = false;
};

const saveRoom = () => {
  console.log('Новое помещение:', roomForm.value);
  closeModal();
};
</script>

<template>
  <v-col cols="auto">
    <v-btn
        type="button"
        color="primary"
        variant="flat"
        prepend-icon="mdi-plus"
        @click="showNewRoom"
    >
      Добавить помещение
    </v-btn>
  </v-col>
  <v-dialog
      v-model="addNewRoom"
      max-width="700"
      scrollable
      persistent
  >
    <v-card>
      <v-card-title class="d-flex align-center py-4">
        <v-icon
            color="primary"
            size="28"
            class="mr-3"
        >
          mdi-office-building-outline
        </v-icon>

        <div>
          <div class="text-h6">
            Добавление помещения
          </div>

          <div class="text-body-2 text-medium-emphasis mt-1">
            Заполните информацию о новом помещении
          </div>
        </div>

        <v-spacer/>

        <v-btn
            icon="mdi-close"
            variant="text"
            @click="closeModal"
        />
      </v-card-title>
      <v-divider/>
      <v-card-text class="pa-6">
        <v-text-field
            v-model="roomForm.department"
            label="Подразделение"
            placeholder="Например, Лаборатория №1"
            variant="outlined"
            prepend-inner-icon="mdi-domain"
            class="mb-4"
            autofocus
        />
        <v-text-field
            v-model="roomForm.responsible"
            label="Ответственный за помещение"
            placeholder="Например, Иванов Иван Иванович"
            variant="outlined"
            prepend-inner-icon="mdi-account-outline"
            class="mb-4"
        />
        <v-text-field
            v-model="roomForm.name"
            label="Наименование помещения"
            placeholder="Например, Помещение для отбора проб"
            variant="outlined"
            prepend-inner-icon="mdi-office-building-outline"
            class="mb-4"
        />
        <v-text-field
            v-model="roomForm.number"
            label="Номер помещения"
            placeholder="Например, №11"
            variant="outlined"
            prepend-inner-icon="mdi-pound"
            class="mb-4"
        />
        <v-text-field
            v-model="roomForm.type"
            label="Тип помещения"
            placeholder="Например, Специальное"
            variant="outlined"
            prepend-inner-icon="mdi-shape-outline"
            class="mb-4"
        />
        <v-text-field
            v-model="roomForm.address"
            label="Адрес помещения"
            placeholder="город Челябинск, ул. Салютная, 2"
            variant="outlined"
            prepend-inner-icon="mdi-map-marker-outline"
            hide-details
        />
      </v-card-text>

      <v-divider/>

      <v-card-actions class="pa-4">
        <v-spacer/>

        <v-btn
            variant="text"
            @click="closeModal"
        >
          Отмена
        </v-btn>

        <v-btn
            color="primary"
            variant="flat"
            prepend-icon="mdi-content-save-outline"
            @click="saveRoom"
        >
          Сохранить
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<style scoped>
</style>
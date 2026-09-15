```vue
<script setup>
import {onMounted, ref} from 'vue';
import {showNotification} from "/app/src/utils/notification.js";

const addNewRoom = ref(false);
const listRoom = ref([]);
const roomForm = ref({
  department: '',
  responsible: '',
  name: '',
  number: '',
  type: '',
  address: '',
});

const headersTable = ref([
  {title: "№ п/п", key: 'id', align: 'start'},
  {title: "Отдел", key: 'id_department', align: 'start'},
  {title: "Ответственный за помещение", key: 'id_assigned', align: 'start'},
  {title: "Номер помещения", key: 'number', align: 'start'},
  {title: "Наименование", key: 'name', align: 'start'},
  {title: "Тип помещения", key: 'type', align: 'start'},
  {title: "Расположение", key: 'room_place', align: 'start'}
])

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

const getRooms = async () => {
  try {
    const getResponse = await fetch('/api/getRooms')
    listRoom.value = await getResponse.json();
    console.log(listRoom);
  } catch (error) {
    console.log(error)
  }
}

const saveRoom = async () => {
  try {
    const save = await fetch('/api/saveRoom', {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(roomForm.value),
    })
    const data = await save.json();

    if (!save.ok) {
      throw new Error(data.message || "Ошибка сохранения помещения");
    }

    closeModal();
    resetForm();
    showNotification("success", "Помещение сохранено", data.message);
  } catch (error) {
    showNotification(
        "error",
        "Ошибка",
        error.message || "Не удалось сохранить помещение"
    );
    closeModal();
    resetForm();
  }
}
onMounted(getRooms)
;
</script>

<template>
  <div class="request_form">
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
    <v-data-table
        :headers="headersTable"
        :items="listRoom"
        class="elevation-2 rounded-lg table-styled mt-6"
        hover
    ></v-data-table>
  </div>
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
/* 🎨 Стили только для таблицы */
:deep(.table-styled) {
  border-radius: 8px !important;
  overflow: hidden;
}

/* Заголовки столбцов */
:deep(.table-styled th) {
  background-color: #f5f5f5 !important;
  font-weight: 600 !important;
  padding: 12px 16px !important;
  white-space: nowrap;
  color: #333 !important;
}

/* Ячейки таблицы */
:deep(.table-styled td) {
  padding: 12px 16px !important;
  white-space: nowrap;
}

/* Чередующийся фон строк (зебра) */
:deep(.table-styled tbody tr:nth-child(even)) {
  background-color: #fafafa;
}

/* Ховер-эффект на строках */
:deep(.table-styled tbody tr:hover) {
  background-color: rgba(33, 150, 243, 0.1) !important;
  transition: background-color 0.2s ease;
}

/* Подвал таблицы (пагинация) */
:deep(.table-styled .v-data-table-footer) {
  background-color: #f5f5f5;
  border-radius: 0 0 8px 8px;
  padding: 12px 16px;
}

/* Выпадающий список строк на странице */
:deep(.table-styled .v-data-table-footer__items-per-page) {
  margin-right: 16px;
}

/* Убираем лишние отступы */
:deep(.table-styled .v-data-table__wrapper) {
  border-radius: 8px;
}
</style>
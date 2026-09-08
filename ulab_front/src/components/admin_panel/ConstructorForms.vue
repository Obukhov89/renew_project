<template>
  <v-container fluid class="pa-6">
    <!-- ========================================================= -->
    <!-- Заголовок -->
    <!-- ========================================================= -->

    <div class="d-flex align-center justify-space-between mb-6">
      <div>
        <div class="text-h5 font-weight-medium">Конструктор форм</div>

        <div class="text-body-2 text-medium-emphasis mt-1">
          Управление формами системы
        </div>
      </div>
    </div>

    <!-- ========================================================= -->
    <!-- Фильтры -->
    <!-- ========================================================= -->

    <v-card class="mb-6" variant="outlined">
      <v-card-text>
        <v-row>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="search"
              label="Поиск формы"
              placeholder="Введите название..."
              prepend-inner-icon="mdi-magnify"
              variant="outlined"
              hide-details
              clearable
            />
          </v-col>

          <v-col cols="12" md="3">
            <v-select
              v-model="selectedModule"
              label="Сущность"
              :items="moduleItems"
              variant="outlined"
              hide-details
            />
          </v-col>

          <v-col cols="12" md="3">
            <v-select
              v-model="selectedStatus"
              :items="['Все', 'Активные', 'Черновики']"
              label="Статус"
              variant="outlined"
              hide-details
            />
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>

    <!-- ========================================================= -->
    <!-- Загрузка -->
    <!-- ========================================================= -->

    <div v-if="loading" class="d-flex justify-center py-10">
      <v-progress-circular indeterminate color="primary" />
    </div>

    <!-- ========================================================= -->
    <!-- Ошибка -->
    <!-- ========================================================= -->

    <v-alert v-else-if="error" type="error" variant="tonal" class="mb-6">
      Не удалось загрузить формы: {{ error }}
    </v-alert>

    <!-- ========================================================= -->
    <!-- Формы -->
    <!-- ========================================================= -->

    <template v-else>
      <div v-for="module in filteredModules" :key="module.id" class="mb-6">
        <!-- Название модуля -->

        <div class="d-flex align-center mb-3">
          <v-icon class="mr-2" color="primary">
            mdi-file-document-outline
          </v-icon>

          <div class="text-h6">
            {{ module.module_name }}
          </div>
        </div>

        <!-- Формы модуля -->

        <v-card
          v-for="form in module.forms"
          :key="form.id"
          class="mb-3"
          variant="outlined"
        >
          <v-card-item>
            <template #prepend>
              <v-avatar color="blue-lighten-5" rounded>
                <v-icon color="primary"> mdi-file-plus-outline </v-icon>
              </v-avatar>
            </template>

            <v-card-title>
              {{ form.form_name }}
            </v-card-title>
          </v-card-item>

          <!-- Информация о форме -->

          <v-card-text class="pt-0">
            <div class="d-flex align-center text-body-2 text-medium-emphasis">
              <span> {{ getFormFieldsCount(form) }} полей </span>

              <v-divider vertical class="mx-3" />

              <span> {{ getVisibleFieldsCount(form) }} видимых </span>

              <v-divider vertical class="mx-3" />

              <span> {{ getRequiredFieldsCount(form) }} обязательных </span>

              <v-divider vertical class="mx-3" />

              <span> Изменена {{ formatDate(form.updated_at) }} </span>
            </div>
          </v-card-text>

          <!-- Действия -->

          <v-card-actions>
            <v-btn
              color="primary"
              variant="text"
              prepend-icon="mdi-pencil-outline"
              @click="openEditForm(form)"
            >
              Редактировать
            </v-btn>

            <v-spacer />

            <v-btn icon="mdi-dots-vertical" variant="text" />
          </v-card-actions>
        </v-card>
      </div>

      <!-- Ничего не найдено -->

      <v-alert v-if="filteredModules.length === 0" type="info" variant="tonal">
        Формы не найдены
      </v-alert>
    </template>

    <!-- ========================================================= -->
    <!-- МОДАЛКА РЕДАКТИРОВАНИЯ ФОРМЫ -->
    <!-- ========================================================= -->

    <v-dialog v-model="editDialog" max-width="1000" scrollable>
      <v-card>
        <!-- Заголовок -->

        <v-card-title class="d-flex align-center py-4">
          <v-icon color="primary" class="mr-3"> mdi-file-edit-outline </v-icon>

          <div>
            <div class="text-h6">Редактирование формы</div>

            <div
              v-if="selectedForm"
              class="text-body-2 text-medium-emphasis mt-1"
            >
              {{ selectedForm.form_name }}
            </div>
          </div>

          <v-spacer />

          <v-btn icon="mdi-close" variant="text" @click="closeEditForm" />
        </v-card-title>

        <v-divider />

        <!-- Содержимое -->

        <v-card-text>
          <div
            v-if="selectedForm"
            class="text-body-2 text-medium-emphasis mb-4"
          >
            Настройте поля формы. Системные поля нельзя удалить,
            пользовательские поля можно создавать и изменять.
          </div>

          <!-- Список полей -->

          <div v-if="selectedForm" class="d-flex flex-column ga-3">
            <v-card
              v-for="(field, index) in editedFields"
              :key="field.id ?? `new-${index}`"
              variant="outlined"
              class="pa-3"
            >
              <v-row align="center" no-gutters>
                <!-- Иконка -->

                <v-col cols="12" md="1" class="d-flex justify-center">
                  <v-icon
                    :color="field.is_system ? 'primary' : 'success'"
                    size="24"
                  >
                    {{ getFieldIcon(field.type_field) }}
                  </v-icon>
                </v-col>

                <!-- Название -->

                <v-col cols="12" md="4" class="px-2">
                  <v-text-field
                    v-model="field.title_field"
                    label="Название поля"
                    variant="outlined"
                    density="comfortable"
                    hide-details
                  />
                </v-col>

                <!-- Системное имя -->

                <v-col cols="12" md="3" class="px-2">
                  <v-text-field
                    :model-value="field.name_field"
                    label="Системное имя"
                    variant="outlined"
                    density="comfortable"
                    hide-details
                    readonly
                  />
                </v-col>

                <!-- Тип -->

                <v-col cols="12" md="2" class="px-2">
                  <v-chip
                    size="small"
                    variant="tonal"
                    :color="field.is_system ? 'primary' : 'success'"
                  >
                    <v-icon start size="16">
                      {{ getFieldIcon(field.type_field) }}
                    </v-icon>

                    {{ getFieldTypeName(field.type_field) }}
                  </v-chip>
                </v-col>

                <!-- Статус -->

                <v-col cols="12" md="2" class="d-flex justify-center">
                  <v-chip
                    v-if="field.is_system"
                    size="small"
                    variant="tonal"
                    color="primary"
                  >
                    Системное
                  </v-chip>

                  <v-chip
                    v-else-if="field.is_new"
                    size="small"
                    variant="tonal"
                    color="success"
                  >
                    Новое
                  </v-chip>

                  <v-chip v-else size="small" variant="tonal" color="success">
                    Пользовательское
                  </v-chip>
                </v-col>
              </v-row>

              <!-- Дополнительные настройки -->

              <div class="d-flex align-center mt-3">
                <v-switch
                  v-model="field.is_visible"
                  label="Видимое"
                  color="primary"
                  density="compact"
                  hide-details
                  class="mr-6"
                />

                <v-switch
                  v-model="field.is_required"
                  label="Обязательное"
                  color="warning"
                  density="compact"
                  hide-details
                />

                <v-spacer />

                <!-- Удалять системные поля нельзя -->

                <v-btn
                  v-if="!field.is_system"
                  icon="mdi-delete-outline"
                  color="error"
                  variant="text"
                  size="small"
                  @click="removeField(index)"
                />
              </div>
            </v-card>

            <!-- Если полей нет -->

            <v-alert
              v-if="editedFields.length === 0"
              type="info"
              variant="tonal"
            >
              В форме пока нет полей.
            </v-alert>
          </div>
        </v-card-text>

        <v-divider />

        <!-- Кнопки -->

        <v-card-actions class="pa-4">
          <v-spacer />

          <v-btn variant="text" @click="closeEditForm"> Отмена </v-btn>

          <v-btn
            color="primary"
            variant="tonal"
            prepend-icon="mdi-plus-box"
            @click="openAddField"
          >
            Добавить новое поле
          </v-btn>

          <v-btn
            color="primary"
            variant="flat"
            prepend-icon="mdi-content-save-outline"
            :loading="saving"
            @click="saveForm"
          >
            Сохранить
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- ========================================================= -->
    <!-- МОДАЛКА ДОБАВЛЕНИЯ ПОЛЯ -->
    <!-- ========================================================= -->

    <v-dialog v-model="addFieldDialog" max-width="600" persistent>
      <v-card>
        <!-- Заголовок -->

        <v-card-title class="d-flex align-center py-4">
          <v-icon color="primary" class="mr-3"> mdi-plus-box </v-icon>

          <div>
            <div class="text-h6">Добавление поля</div>

            <div class="text-body-2 text-medium-emphasis mt-1">
              Новое пользовательское поле
            </div>
          </div>

          <v-spacer />

          <v-btn icon="mdi-close" variant="text" @click="closeAddField" />
        </v-card-title>

        <v-divider />

        <!-- Форма -->

        <v-card-text>
          <v-text-field
            v-model="newField.title_field"
            label="Название поля"
            placeholder="Например, Наименование материала"
            variant="outlined"
            class="mb-3"
            autofocus
          />

          <v-text-field
            v-model="newField.name_field"
            label="Системное имя"
            placeholder="Например, material_name"
            variant="outlined"
            class="mb-3"
          />

          <v-select
            v-model="newField.type_field"
            label="Тип поля"
            :items="FIELD_TYPES"
            item-title="title"
            item-value="value"
            variant="outlined"
            class="mb-3"
          />

          <!-- Размер -->

          <v-text-field
            v-if="newField.type_field === 'text'"
            v-model="newField.size_field"
            label="Размер поля"
            placeholder="Например, 255"
            type="number"
            variant="outlined"
            class="mb-3"
          />

          <!-- Точность -->

          <v-text-field
            v-if="newField.type_field === 'number'"
            v-model="newField.precission_field"
            label="Точность"
            placeholder="Например, 2"
            type="number"
            variant="outlined"
            class="mb-3"
          />

          <v-switch
            v-model="newField.is_required"
            label="Обязательное поле"
            color="primary"
            hide-details
            class="mb-2"
          />

          <v-switch
            v-model="newField.is_visible"
            label="Поле отображается"
            color="primary"
            hide-details
          />
        </v-card-text>

        <v-divider />

        <!-- Кнопки -->

        <v-card-actions class="pa-4">
          <v-spacer />

          <v-btn variant="text" @click="closeAddField"> Отмена </v-btn>

          <v-btn
            color="primary"
            variant="flat"
            prepend-icon="mdi-plus"
            :disabled="!canAddField"
            @click="addField"
          >
            Добавить
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>


<script setup>
import { ref, computed, onMounted } from "vue";
import { useFormEditor } from "/src/composables/useFormEditor";
import { FIELD_TYPES, getFieldType } from "/src/utils/constructorFieldTypes";

// ================================================================
// Состояние
// ================================================================

const modules = ref([]);

const loading = ref(false);

const saving = ref(false);

const error = ref(null);

// ================================================================
// Фильтры
// ================================================================

const search = ref("");

const selectedModule = ref("Все сущности");

const selectedStatus = ref("Все");

const {
  editDialog,
  selectedForm,
  editedFields,
  openEditForm,
  closeEditForm,
  getEmptyField,
} = useFormEditor();

const addFieldDialog = ref(false);

const newField = ref(getEmptyField());

// ================================================================
// Можно ли добавить поле
// ================================================================

const canAddField = computed(() => {
  return (
    newField.value.title_field.trim() !== "" &&
    newField.value.name_field.trim() !== ""
  );
});

// ================================================================
// Получение форм
// ================================================================

const getModuleForms = async () => {
  loading.value = true;

  error.value = null;

  try {
    const response = await fetch("/api/constructor/forms");

    if (!response.ok) {
      throw new Error(`Ошибка HTTP: ${response.status}`);
    }

    modules.value = await response.json();

    console.log("Модули и формы:", modules.value);
  } catch (err) {
    console.error("Ошибка загрузки форм:", err);

    error.value = err.message;
  } finally {
    loading.value = false;
  }
};

// ================================================================
// Список модулей для фильтра
// ================================================================

const moduleItems = computed(() => {
  return ["Все сущности", ...modules.value.map((module) => module.module_name)];
});

// ================================================================
// Фильтрация
// ================================================================

const filteredModules = computed(() => {
  const searchValue = search.value.trim().toLowerCase();

  return modules.value

    .map((module) => {
      let forms = [...(module.forms || [])];

      // Фильтр модуля

      if (
        selectedModule.value !== "Все сущности" &&
        module.module_name !== selectedModule.value
      ) {
        return {
          ...module,
          forms: [],
        };
      }

      // Поиск

      if (searchValue) {
        forms = forms.filter((form) =>
          form.form_name.toLowerCase().includes(searchValue)
        );
      }

      // Статус

      if (selectedStatus.value === "Активные") {
        forms = forms.filter((form) => form.is_active !== false);
      }

      if (selectedStatus.value === "Черновики") {
        forms = forms.filter((form) => form.is_active === false);
      }

      return {
        ...module,
        forms,
      };
    })

    .filter((module) => module.forms.length > 0);
});

// ================================================================
// Количество всех полей
// ================================================================

const getFormFields = (form) => {
  return [...(form.fields || []), ...(form.custom_fields || [])];
};

const getFormFieldsCount = (form) => {
  return getFormFields(form).length;
};

const getVisibleFieldsCount = (form) => {
  return getFormFields(form).filter((field) => field.is_visible).length;
};

const getRequiredFieldsCount = (form) => {
  return getFormFields(form).filter((field) => field.is_required).length;
};

const openAddField = () => {
  newField.value = getEmptyField();

  addFieldDialog.value = true;
};

// ================================================================
// Закрытие добавления поля
// ================================================================

const closeAddField = () => {
  addFieldDialog.value = false;
};

// ================================================================
// Добавление нового поля
// ================================================================

const addField = () => {
  if (!canAddField.value) {
    return;
  }

  const field = {
    ...newField.value,

    id: null,

    module_id: selectedForm.value.module_id,

    form_id: selectedForm.value.id,

    is_system: false,

    is_new: true,

    created_at: null,

    updated_at: null,
  };

  editedFields.value.push(field);

  addFieldDialog.value = false;
};

// ================================================================
// Удаление поля из текущей формы
// ================================================================

const removeField = (index) => {
  const field = editedFields.value[index];

  // Системное поле удалять нельзя

  if (field.is_system) {
    return;
  }

  editedFields.value.splice(index, 1);
};

// ================================================================
// Сохранение формы
// ================================================================

const saveForm = async () => {
  saving.value = true;

  error.value = null;

  try {
    console.log("Отправляемые поля:", editedFields.value);

    const response = await fetch("/api/constructor/updateSystemFieldsForm", {
      method: "POST",

      headers: {
        "Content-Type": "application/json",

        Accept: "application/json",
      },

      body: JSON.stringify({
        fields: editedFields.value,
      }),
    });

    if (!response.ok) {
      throw new Error(`Ошибка HTTP: ${response.status}`);
    }

    const result = await response.json();

    console.log("Результат сохранения:", result);

    await getModuleForms();

    closeEditForm();
  } catch (err) {
    console.error("Ошибка сохранения полей:", err);

    error.value = err.message;
  } finally {
    saving.value = false;
  }
};

// ================================================================
// Форматирование даты
// ================================================================

const formatDate = (date) => {
  if (!date) {
    return "";
  }

  return new Date(date).toLocaleDateString("ru-RU");
};

// ================================================================
// Иконки
// ================================================================

const getFieldIcon = (type) => {
  const icons = {
    text: "mdi-form-textbox",

    email: "mdi-email-outline",

    tel: "mdi-phone-outline",

    number: "mdi-numeric",

    select: "mdi-form-select",

    date: "mdi-calendar-outline",

    textarea: "mdi-text-box-outline",

    checkbox: "mdi-checkbox-outline",

    radio: "mdi-radiobox-marked",

    file: "mdi-file-upload-outline",
  };

  return icons[type] || "mdi-form-textbox";
};

// ================================================================
// Названия типов
// ================================================================

const getFieldTypeName = (type) => {
  const item = FIELD_TYPES.find((item) => item.value === type);

  return item ? item.title : type;
};

onMounted(() => {
  getModuleForms();
});
</script>
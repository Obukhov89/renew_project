<template>
  <v-card class="module-permissions" elevation="0">
    <v-card-title class="px-6 py-4">
      <div class="text-h6">Настройка модулей</div>

      <div class="text-body-2 text-medium-emphasis mt-1">
        Выберите роли, которым доступна настройка каждого модуля
      </div>
    </v-card-title>

    <v-divider />

    <v-card-text class="pa-0">
      <!-- Заголовок -->
      <div class="module-row module-header">
        <div>Модуль</div>
        <div>Роли</div>
      </div>

      <!-- Модули -->
      <div v-for="module in modules" :key="module.id" class="module-row">
        <!-- Модуль -->
        <div class="module-info">
          <div class="module-icon">
            <v-icon :icon="module.icon" />
          </div>

          <div>
            <div class="module-name">
              {{ module.name }}
            </div>

            <div class="module-description">
              {{ module.description }}
            </div>
          </div>
        </div>

        <!-- Роли -->
        <div class="module-roles">
          <v-select
            v-model="module.roles"
            :items="roles"
            item-title="name"
            item-value="id"
            label="Выберите роли"
            multiple
            chips
            closable-chips
            variant="outlined"
            density="compact"
            hide-details
          />
        </div>
      </div>
    </v-card-text>

    <v-divider />

    <v-card-actions class="px-6 py-4">
      <v-spacer />

      <v-btn color="primary" prepend-icon="mdi-content-save-outline">
        Сохранить
      </v-btn>
    </v-card-actions>
  </v-card>
</template>


<script setup>
import { ref } from "vue";

const roles = ref([
  {
    id: 1,
    name: "Администратор",
  },
  {
    id: 2,
    name: "Менеджер",
  },
  {
    id: 3,
    name: "Лаборант",
  },
  {
    id: 4,
    name: "Наблюдатель",
  },
]);

const modules = ref([
  {
    id: 1,
    name: "Заявки",
    description: "Управление входящими заявками",
    icon: "mdi-file-document-outline",
    roles: [1, 2],
  },

  {
    id: 2,
    name: "Договоры",
    description: "Работа с договорами",
    icon: "mdi-file-sign",
    roles: [1],
  },

  {
    id: 3,
    name: "Испытания",
    description: "Результаты испытаний и методики",
    icon: "mdi-flask-outline",
    roles: [1, 3],
  },

  {
    id: 4,
    name: "Пользователи",
    description: "Пользователи и их роли",
    icon: "mdi-account-group-outline",
    roles: [1],
  },
]);
</script>


<style scoped>
.module-permissions {
  width: 100%;
  margin: 1rem;
  border: 1px solid rgba(var(--v-border-color), var(--v-border-opacity));
  border-radius: 12px;
  overflow: hidden;
}

.module-row {
  display: grid;

  grid-template-columns: 40% 60%;

  align-items: center;

  min-height: 80px;

  padding: 12px 24px;

  border-bottom: 1px solid rgba(var(--v-border-color), 0.5);
}

.module-header {
  min-height: 48px;

  background: rgba(var(--v-theme-on-surface), 0.025);

  font-size: 13px;

  font-weight: 600;

  color: rgba(var(--v-theme-on-surface), 0.6);
}

.module-info {
  display: flex;

  align-items: center;

  gap: 14px;
}

.module-icon {
  width: 42px;
  height: 42px;

  display: flex;

  align-items: center;
  justify-content: center;

  border-radius: 10px;

  background: rgba(var(--v-theme-primary), 0.08);

  color: rgb(var(--v-theme-primary));
}

.module-name {
  font-size: 15px;

  font-weight: 500;
}

.module-description {
  margin-top: 3px;

  font-size: 13px;

  color: rgba(var(--v-theme-on-surface), 0.55);
}

.module-roles {
  padding-left: 20px;

  max-width: 650px;
}
</style>
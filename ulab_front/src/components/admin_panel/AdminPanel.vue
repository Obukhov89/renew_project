<template>
  <div class="panel_content">
    <nav class="settings_menu">
      <v-list>
        <v-list-item title="Модули" to="/admin/modules">
          <template #prepend>
            <v-icon color="blue-darken-4"> mdi-view-dashboard-outline </v-icon>
          </template>
        </v-list-item>
        <v-list-item title="Пользователи">
          <template #prepend>
            <v-icon color="blue-darken-4"> mdi-view-dashboard-outline </v-icon>
          </template>
        </v-list-item>
      </v-list>
    </nav>
    <RouterView />
  </div>
</template>
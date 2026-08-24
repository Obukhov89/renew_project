<template>
  <nav class="left-menu">
    <v-list class="left-menu-list">
      <v-list-item
        title="Заявка на испытания"
        to="/request/new"
        prepend-icon="mdi-tooltip-edit-outline"
      />

      <v-list-item
        title="Главная"
        to="/"
        prepend-icon="mdi-view-dashboard-outline"
      />

      <v-list-item
        title="Настройки"
        to="/admin"
        prepend-icon="mdi-cog-outline"
      />
    </v-list>
  </nav>
</template>
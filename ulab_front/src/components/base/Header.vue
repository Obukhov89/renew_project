<template>
  <header class="app-header">
    <button class="menu-button" @click="emit('toggle-left-menu')">
      <v-icon>mdi-menu</v-icon>
    </button>

    <div class="header-title">ULAB Admin</div>

    <div class="header-spacer"></div>

    <v-btn icon="mdi-bell-outline" variant="text" />

    <v-btn prepend-icon="mdi-account-circle-outline" variant="text">
      Данил
    </v-btn>
  </header>
</template>

<script setup>
const emit = defineEmits(["toggle-left-menu"]);
</script>
<template>
  <div class="container" :class="{ 'sidebar-collapsed': !isSidebarOpen }">
    <div class="header"><Header @toggle-left-menu="toggleLeftMenu" /></div>
    <div class="sidebar">
      <LeftMenu />
    </div>
    <div class="work_area">
      <RouterView />
    </div>
    <Notification />
  </div>
</template>

<script setup>
import { ref } from "vue";
import Header from "./Header.vue";
import LeftMenu from "./LeftMenu.vue";
import Notification from "../notification/Notification.vue";

const isSidebarOpen = ref(true);

function toggleLeftMenu() {
  isSidebarOpen.value = !isSidebarOpen.value;
}
</script>
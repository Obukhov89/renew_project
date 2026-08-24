<template>
  <Transition name="notification">
    <div
      v-if="notification.visible"
      class="notification"
      :class="`notification--${notification.type}`"
    >
      <div class="notification-icon">
        <v-icon>
          {{ icon }}
        </v-icon>
      </div>

      <div class="notification-content">
        <div class="notification-title">
          {{ notification.title }}
        </div>

        <div v-if="notification.message" class="notification-message">
          {{ notification.message }}
        </div>
      </div>

      <button class="notification-close" @click="close">
        <v-icon size="18"> mdi-close </v-icon>
      </button>
    </div>
  </Transition>
</template>

<script setup>
import { computed, watch } from "vue";
import { notification, hideNotification } from "/app/src/utils/notification";

const icon = computed(() => {
  switch (notification.value.type) {
    case "success":
      return "mdi-check-circle";

    case "error":
      return "mdi-alert-circle";

    case "warning":
      return "mdi-alert";

    case "info":
    default:
      return "mdi-information";
  }
});

const close = () => {
  hideNotification();
};

watch(
  () => notification.value.visible,
  (visible) => {
    if (!visible) {
      return;
    }

    const timeout = notification.value.timeout;

    if (timeout > 0) {
      setTimeout(() => {
        hideNotification();
      }, timeout);
    }
  }
);
</script>

<style scoped>
.notification {
  position: absolute;

  top: 20px;
  right: -20px;

  width: 340px;

  display: flex;
  align-items: flex-start;

  gap: 12px;

  padding: 14px 16px;

  border-radius: 10px;

  background: rgb(var(--v-theme-surface));

  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);

  z-index: 100;
}

.notification-icon {
  display: flex;
  align-items: center;
  justify-content: center;
}

.notification-content {
  flex: 1;
  min-width: 0;
}

.notification-title {
  font-weight: 600;
  font-size: 14px;
}

.notification-message {
  margin-top: 4px;

  font-size: 13px;

  opacity: 0.7;
}

.notification-close {
  display: flex;
  align-items: center;
  justify-content: center;

  border: none;
  background: transparent;

  cursor: pointer;

  opacity: 0.5;
}

.notification-close:hover {
  opacity: 1;
}

/* SUCCESS */

.notification--success {
  border-left: 4px solid rgb(var(--v-theme-success));
}

.notification--success .notification-icon {
  color: rgb(var(--v-theme-success));
}

/* ERROR */

.notification--error {
  border-left: 4px solid rgb(var(--v-theme-error));
}

.notification--error .notification-icon {
  color: rgb(var(--v-theme-error));
}

/* WARNING */

.notification--warning {
  border-left: 4px solid rgb(var(--v-theme-warning));
}

.notification--warning .notification-icon {
  color: rgb(var(--v-theme-warning));
}

/* INFO */

.notification--info {
  border-left: 4px solid rgb(var(--v-theme-info));
}

.notification--info .notification-icon {
  color: rgb(var(--v-theme-info));
}

/* ANIMATION */

.notification-enter-active,
.notification-leave-active {
  transition: all 0.3s ease;
}

.notification-enter-from {
  opacity: 0;
  transform: translateX(40px);
}

.notification-leave-to {
  opacity: 0;
  transform: translateX(40px);
}
</style>
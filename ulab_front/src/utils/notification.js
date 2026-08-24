import { ref } from "vue";

export const notification = ref({
    visible: false,
    type: "info",
    title: "",
    message: "",
    timeout: 4000,
});

export function showNotification(
    type = "info",
    title = "Уведомление",
    message = "",
    timeout = 4000
) {
    notification.value = {
        visible: true,
        type,
        title,
        message,
        timeout,
    };
}

export function hideNotification() {
    notification.value.visible = false;
}
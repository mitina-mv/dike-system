<template>
    <div v-if="message" :class="[statusClass]">
        {{ message }}
    </div>
</template>

<script>
export default {
    props: {
        message: {
            type: String,
            default: "",
        },
        status: {
            type: String,
            default: "",
            validator: (value) =>
                ["success", "warning", "error"].includes(value.toLowerCase()),
        },
    },
    computed: {
        statusClass() {
            switch (this.status.toLowerCase()) {
                case "success":
                    return "success-message"; // Заменить на имя класса для сообщения об успехе
                case "warning":
                    return "warning-message"; // Заменить на имя класса для сообщения-предупреждения
                case "error":
                    return "error-message"; // Заменить на имя класса для сообщения о неудаче
                default:
                    return "";
            }
        },
    },
};
</script>

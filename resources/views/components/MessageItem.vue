<script lang="ts" setup>
import formatDateToHoursMinutes from "@/scripts/utils/date";

defineProps<{
    message: App.Data.MessageData;
}>();
</script>

<template>
    <div class="text-white">
        <span class="mr-2 font-normal text-gray-300">{{ formatDateToHoursMinutes(message.created_at) }}</span>
        <span class="font-bold">{{ message.user_name }}</span>
        <p class="font-normal text-gray-200">{{ message.content }}</p>
    </div>
</template>

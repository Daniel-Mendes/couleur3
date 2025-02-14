<script lang="ts" setup>
import MessageItem from "@/views/components/MessageItem.vue";
import BaseCard from "@/views/components/animator/basics/BaseCard.vue";
import BaseButton from "@/views/components/animator/basics/BaseButton.vue";
import Color from "@/scripts/enums/Color.js";
import { useChatStore } from "@/scripts/stores/useChatStore.js";
import { storeToRefs } from "pinia";
import { useForm } from "@inertiajs/vue3";
import { watch } from "vue";

const chatStore = useChatStore();
const { isChatEnabled, messages } = storeToRefs(chatStore);

const form = useForm({
    chat_enabled: !isChatEnabled.value,
});

watch(
    () => isChatEnabled.value,
    (newValue) => {
        form.chat_enabled = !newValue;
    }
);

const submit = () => {
    form.post(route("settings.update"), {
        preserveScroll: true,
        only: ["chatEnabled"],
    });
};
</script>

<template>
    <BaseCard :color="Color.WHITE">
        <template #title>Chat</template>
        <template #content>
            <ul
                class="h-[55vh] flex-col gap-2 overflow-y-scroll scrollbar-thin scrollbar-thumb-white scrollbar-thumb-rounded">
                <li
                    v-for="msg in messages"
                    :key="msg.id">
                    <MessageItem :msg="msg" />
                </li>
            </ul>
        </template>
        <template #actions>
            <form @submit.prevent="submit">
                <BaseButton :disabled="form.processing">
                    {{ isChatEnabled ? "Désactiver le chat" : "Activer le chat" }}
                </BaseButton>
            </form>
        </template>
    </BaseCard>
</template>

<style scoped>
.list-move,
.list-enter-active,
.list-leave-active {
    transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateX(30px);
}

.list-leave-active {
    position: absolute;
}
</style>

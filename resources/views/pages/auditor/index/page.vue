<script lang="ts" setup>
import LayoutAuditor from "@/views/layouts/auditor/layout-auditor.vue";
import Player from "./partials/Player.vue";
import DescriptionLive from "./partials/DescriptionLive.vue";
import Popups from "./partials/Popups.vue";
import Notifications from "./partials/Notifications.vue";
import Chat from "./partials/Chat.vue";

defineProps<{
    chatEnabled: boolean;
    user: Object | null;
}>();
</script>

<template>
    <LayoutAuditor :user="user">
        <Head title="Lecteur" />
        <Player />
        <DescriptionLive />
        <Popups :user="user" />
        <div
            id="fixed-container"
            class="fixed bottom-16 flex w-screen flex-col">
            <Notifications :user="user" />
            <Chat
                :chat-enabled="chatEnabled"
                class="grow" />
        </div>
    </LayoutAuditor>
</template>

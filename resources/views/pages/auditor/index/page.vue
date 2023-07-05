<script lang="ts" setup>
import LayoutAuditor from "@/views/layouts/auditor/layout-auditor.vue";
import Player from "./partials/Player.vue";
import DescriptionLive from "./partials/DescriptionLive.vue";
import Popups from "./partials/Popups.vue";
import Notifications from "./partials/Notifications.vue";
import Chat from "./partials/Chat.vue";

defineProps<{
    chatEnabled: boolean;
    auth: App.Data.UserData | null;
}>();
</script>

<template>
    <LayoutAuditor :auth="auth">
        <Head title="Lecteur" />
        <Player />
        <DescriptionLive />
        <Popups :auth="auth" />
        <div
            id="fixed-container"
            class="fixed bottom-16 flex w-screen flex-col">
            <Notifications :auth="auth" />
            <Chat
                :chat-enabled="chatEnabled"
                class="grow" />
        </div>
    </LayoutAuditor>
</template>

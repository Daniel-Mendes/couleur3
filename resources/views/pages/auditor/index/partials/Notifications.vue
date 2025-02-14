<script lang="ts" setup>
import InteractionType from "@/scripts/enums/InteractionType.js";
import { useInteractionStore } from "@/scripts/stores/useInteractionStore.js";
import { storeToRefs } from "pinia";
import BaseNotif from "@/views/components/Auditor/Bases/BaseNotif.vue";

// permet de récupérer la personne authentifiée si elle existe
const props = defineProps<{
    auth: Object | null;
}>();
const interactionStore = useInteractionStore();
const { currentInteraction, hasOpenedNotif, hasAnswerd } = storeToRefs(interactionStore);

function clicNotif() {
    if (currentInteraction.value.type === InteractionType.QUICK_CLICK && props.auth === null) {
        (document.querySelector("#popup-auditor") as HTMLDialogElement).showModal();
    } else if (
        currentInteraction.value.type === InteractionType.QUICK_CLICK ||
        currentInteraction.value.type === InteractionType.TEXT ||
        currentInteraction.value.type === InteractionType.SURVEY ||
        currentInteraction.value.type === InteractionType.MCQ ||
        currentInteraction.value.type === InteractionType.AUDIO ||
        currentInteraction.value.type === InteractionType.VIDEO ||
        currentInteraction.value.type === InteractionType.PICTURE
    ) {
        // l'auditeur à ouvert la notification
        hasOpenedNotif.value = true;
        // Ouvre la modal
        (document.querySelector("#popup-auditor") as HTMLDialogElement).showModal();
    } else if (currentInteraction.value.type === InteractionType.CTA) {
        // l'auditeur à ouvert la notification
        hasOpenedNotif.value = true;
        // Redirige l'auditeur sur le lien
        window.open(currentInteraction.value.call_to_action.link, "_blank");
    }
}
</script>

<template>
    <BaseNotif
        v-if="
            currentInteraction &&
            (currentInteraction.type === InteractionType.SURVEY ||
                currentInteraction.type === InteractionType.MCQ ||
                currentInteraction.type === InteractionType.AUDIO ||
                currentInteraction.type === InteractionType.VIDEO ||
                currentInteraction.type === InteractionType.PICTURE)
        "
        id="notification-animateur"
        @click="clicNotif">
        Interagir avec l’animateur
    </BaseNotif>
    <BaseNotif
        v-if="!hasAnswerd && currentInteraction && currentInteraction.type === InteractionType.TEXT"
        id="notification-animateur-text"
        @click="clicNotif">
        Interagir avec l’animateur
    </BaseNotif>
    <BaseNotif
        v-if="currentInteraction && currentInteraction.type === InteractionType.QUICK_CLICK && hasOpenedNotif === false"
        id="notification-rapide"
        @click="clicNotif">
        {{ currentInteraction.title }}
    </BaseNotif>
    <BaseNotif
        v-if="currentInteraction && currentInteraction.type === InteractionType.CTA"
        id="notification-lien"
        @click="clicNotif">
        <span class="flex gap-x-1"
            ><span>{{ currentInteraction.title }}</span>
            <span
                id="link"
                class="material-symbols-rounded text-xl"
                >open_in_new</span
            >
        </span>
    </BaseNotif>
</template>

<style scoped>
#link {
    font-variation-settings: "wght" 600;
}
</style>

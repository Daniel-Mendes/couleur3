<script lang="ts" setup>
import BaseCard from "@/views/components/animator/basics/BaseCard.vue";
import BaseButton from "@/views/components/animator/basics/BaseButton.vue";
import BaseCountdown from "@/views/components/animator/basics/BaseCountdown.vue";
import Color from "@/scripts/enums/Color.js";
import EndingMessage from "../answers/EndingMessage.vue";
import { useInteractionStore } from "@/scripts/stores/useInteractionStore.js";
import { storeToRefs } from "pinia";

const interactionStore = useInteractionStore();
const { currentInteraction } = storeToRefs(interactionStore);

const duration = new Date(currentInteraction.value.ended_at).getTime() - new Date().getTime();
const sec = Math.floor((duration / 1000) % 60);
const min = Math.floor(duration / (1000 * 60));
</script>

<template>
    <BaseCard :color="Color.SECONDARY">
        <template #title>
            <div class="flex flex-auto flex-row items-center justify-between">
                <EndingMessage />

                <BaseCountdown
                    :color="Color.SECONDARY"
                    :sec="sec"
                    :min="min" />
            </div>
        </template>
        <template #subtitle>Le lien suivant a bien été envoyé aux auditeurs :</template>
        <template #content>
            <span class="font-light italic"
                >{{ currentInteraction.title }} - {{ currentInteraction.call_to_action.link }}</span
            >
        </template>

        <template #actions>
            <div class="flex flex-row gap-3">
                <BaseButton @click="interactionStore.endInteraction()">Fin de l'interaction</BaseButton>
            </div>
        </template>
    </BaseCard>
</template>

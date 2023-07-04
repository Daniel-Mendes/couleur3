<script setup>
import BaseCard from "@/Components/Animator/Bases/BaseCard.vue";
import BaseButton from "@/Components/Animator/Bases/BaseButton.vue";
import InteractionType from "@/Enums/InteractionType.js";
import { useInteractionStore } from "@/Stores/useInteractionStore.js";
import Color from "@/Enums/Color.js";

const interactionStore = useInteractionStore();
</script>

<template>
    <BaseCard :color="Color.SECONDARY">
        <template #title>Lien</template>
        <template #subtitle>
            Envoyez un lien de redirection aux auditeurs
        </template>
        <template #actions>
            <BaseButton
                :color="Color.SECONDARY"
                @click="
                    interactionStore.creatingInteraction(InteractionType.CTA)
                "
            >
                Créer
            </BaseButton>
        </template>
    </BaseCard>
</template>

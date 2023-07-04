<script setup>
import BaseCard from "@/Components/Animator/Bases/BaseCard.vue";
import BaseButton from "@/Components/Animator/Bases/BaseButton.vue";
import InteractionType from "@/Enums/InteractionType.js";
import { useInteractionStore } from "@/Stores/useInteractionStore.js";
import Color from "@/Enums/Color.js";

const interactionStore = useInteractionStore();
</script>

<template>
    <BaseCard :color="Color.ACCENT">
        <template #title>Rapidité</template>
        <template #subtitle>
            Envoyez un bouton de participation de rapidité aux auditeurs
        </template>

        <template #actions>
            <BaseButton
                :color="Color.ACCENT"
                @click="
                    interactionStore.creatingInteraction(
                        InteractionType.QUICK_CLICK
                    )
                "
                >Créer</BaseButton
            >
        </template>
    </BaseCard>
</template>

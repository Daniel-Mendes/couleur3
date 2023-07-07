<script lang="ts" setup>
import BaseCard from "@/views/components/animator/basics/BaseCard.vue";
import BaseButton from "@/views/components/animator/basics/BaseButton.vue";
import { useInteractionStore } from "@/scripts/stores/useInteractionStore.js";
import Color from "@/scripts/enums/Color.js";

const interactionStore = useInteractionStore();
</script>

<template>
    <BaseCard :color="Color.ACCENT">
        <template #title>Rapidité</template>
        <template #subtitle> Envoyez un bouton de participation de rapidité aux auditeurs </template>

        <template #actions>
            <BaseButton
                :color="Color.ACCENT"
                @click="interactionStore.creatingInteraction('QUICK_CLICK')"
                >Créer</BaseButton
            >
        </template>
    </BaseCard>
</template>

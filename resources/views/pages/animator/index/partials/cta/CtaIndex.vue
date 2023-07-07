<script lang="ts" setup>
import BaseCard from "@/views/components/animator/basics/BaseCard.vue";
import BaseButton from "@/views/components/animator/basics/BaseButton.vue";
import { useInteractionStore } from "@/scripts/stores/useInteractionStore.js";
import Color from "@/scripts/enums/Color.js";

const interactionStore = useInteractionStore();
</script>

<template>
    <BaseCard :color="Color.SECONDARY">
        <template #title>Lien</template>
        <template #subtitle> Envoyez un lien de redirection aux auditeurs </template>
        <template #actions>
            <BaseButton
                :color="Color.SECONDARY"
                @click="interactionStore.creatingInteraction('CTA')">
                Créer
            </BaseButton>
        </template>
    </BaseCard>
</template>

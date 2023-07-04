<script setup>
import BaseCard from "@/Components/Animator/Bases/BaseCard.vue";
import BaseButton from "@/Components/Animator/Bases/BaseButton.vue";
import BaseCountdown from "@/Components/Animator/Bases/BaseCountdown.vue";
import BaseTabs from "@/Components/Animator/Bases/BaseTabs.vue";
import BaseTab from "@/Components/Animator/Bases/BaseTab.vue";
import AnswersList from "@/Components/Animator/Answers/AnswersList.vue";
import AnswersSelectFastest from "@/Components/Animator/Answers/AnswersSelectFastest.vue";
import Color from "@/Enums/Color.js";
import { ref } from "vue";
import { calculateDuration } from "@/Utils/time.js";
import { useInteractionStore } from "@/Stores/useInteractionStore.js";
import { storeToRefs } from "pinia";

const interactionStore = useInteractionStore();
const { currentInteraction } = storeToRefs(interactionStore);

const { min, sec } = calculateDuration(
    currentInteraction.value.ended_at,
    new Date()
);

const activeTab = ref(0);
</script>

<template>
    <BaseCard :color="Color.ACCENT">
        <template #title>
            <div class="flex flex-auto flex-row items-center justify-between">
                {{ currentInteraction.title }}
                <BaseCountdown :color="Color.ACCENT" :sec="sec" :min="min" />
            </div>
        </template>
        <template #content>
            <BaseTabs v-model="activeTab" :color="Color.ACCENT">
                <BaseTab title="Réponses">
                    <AnswersList />
                </BaseTab>
                <BaseTab title="Sélection des premiers">
                    <div>
                        <p class="font-light">
                            Cliquez sur les utilisateurs que vous souhaitez
                            faire gagner.
                        </p>
                    </div>
                    <AnswersSelectFastest />
                </BaseTab>
            </BaseTabs>
        </template>
        <template #actions>
            <div class="flex flex-row gap-3">
                <BaseButton
                    type="submit"
                    @click="interactionStore.endInteraction()"
                >
                    Fin de l'interaction
                </BaseButton>

                <BaseButton
                    v-if="activeTab === 1"
                    type="submit"
                    :color="Color.ACCENT"
                    @click="interactionStore.submitFastest()"
                >
                    Confirmer
                </BaseButton>
            </div>
        </template>
    </BaseCard>
</template>

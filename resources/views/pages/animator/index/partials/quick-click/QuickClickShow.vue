<script lang="ts" setup>
import BaseCard from "@/views/components/animator/basics/BaseCard.vue";
import BaseButton from "@/views/components/animator/basics/BaseButton.vue";
import BaseCountdown from "@/views/components/animator/basics/BaseCountdown.vue";
import BaseTabs from "@/views/components/animator/basics/BaseTabs.vue";
import BaseTab from "@/views/components/animator/basics/BaseTab.vue";
import AnswersList from "../answers/AnswersList.vue";
import AnswersSelectFastest from "../answers/AnswersSelectFastest.vue";
import Color from "@/scripts/enums/Color.js";
import { ref } from "vue";
import { calculateDuration } from "@/scripts/utils/time.js";
import { useInteractionStore } from "@/scripts/stores/useInteractionStore.js";
import { storeToRefs } from "pinia";

const interactionStore = useInteractionStore();
const { currentInteraction } = storeToRefs(interactionStore);

const { min, sec } = calculateDuration(currentInteraction.value.ended_at, new Date());

const activeTab = ref(0);
</script>

<template>
    <BaseCard :color="Color.ACCENT">
        <template #title>
            <div class="flex flex-auto flex-row items-center justify-between">
                {{ currentInteraction.title }}
                <BaseCountdown
                    :color="Color.ACCENT"
                    :sec="sec"
                    :min="min" />
            </div>
        </template>
        <template #content>
            <BaseTabs
                v-model="activeTab"
                :color="Color.ACCENT">
                <BaseTab title="Réponses">
                    <AnswersList />
                </BaseTab>
                <BaseTab title="Sélection des premiers">
                    <div>
                        <p class="font-light">Cliquez sur les utilisateurs que vous souhaitez faire gagner.</p>
                    </div>
                    <AnswersSelectFastest />
                </BaseTab>
            </BaseTabs>
        </template>
        <template #actions>
            <div class="flex flex-row gap-3">
                <BaseButton
                    type="submit"
                    @click="interactionStore.endInteraction()">
                    Fin de l'interaction
                </BaseButton>

                <BaseButton
                    v-if="activeTab === 1"
                    type="submit"
                    :color="Color.ACCENT"
                    @click="interactionStore.submitFastest()">
                    Confirmer
                </BaseButton>
            </div>
        </template>
    </BaseCard>
</template>

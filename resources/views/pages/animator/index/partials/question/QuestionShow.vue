<script lang="ts" setup>
import BaseCard from "@/views/components/animator/basics/BaseCard.vue";
import BaseButton from "@/views/components/animator/basics/BaseButton.vue";
import BaseCountdown from "@/views/components/animator/basics/BaseCountdown.vue";
import BaseTabs from "@/views/components/animator/basics/BaseTabs.vue";
import BaseTab from "@/views/components/animator/basics/BaseTab.vue";
import AnswersBarChart from "../answers/AnswersBarChart.vue";
import AnswersList from "../answers/AnswersList.vue";
import AnswersSelectManual from "../answers/AnswersSelectManual.vue";
import AnswersSelectRandom from "../answers/AnswersSelectRandom.vue";
import AnswersSelectFastest from "../answers/AnswersSelectFastest.vue";
import AnswersSimple from "../answers/AnswersSimple.vue";
import InteractionType from "@/scripts/enums/InteractionType.js";
import Color from "@/scripts/enums/Color.js";
import { calculateDuration } from "@/scripts/utils/time.js";
import { ref } from "vue";
import { useInteractionStore } from "@/scripts/stores/useInteractionStore.js";
import { storeToRefs } from "pinia";

const interactionStore = useInteractionStore();
const { currentInteraction } = storeToRefs(interactionStore);

const { min, sec } = calculateDuration(currentInteraction.value.ended_at, new Date());

const activeTab = ref(0);
const isDisplayed = ref(false);
const questionDisplayed = ref(null);
const answersDisplayed = ref(null);

function displayDetails(questionChoice, answers) {
    questionDisplayed.value = questionChoice;
    answersDisplayed.value = answers;
    isDisplayed.value = true;
}
function hideDetails() {
    isDisplayed.value = false;
}
</script>

<template>
    <BaseCard
        v-if="currentInteraction && InteractionType.isQuestion(currentInteraction.type)"
        :color="Color.PRIMARY">
        <template #title>
            <div class="flex flex-auto flex-row justify-between">
                {{ currentInteraction.title }}
                <BaseCountdown
                    :color="Color.PRIMARY"
                    :sec="sec"
                    :min="min" />
            </div>
        </template>
        <template #content>
            <BaseTabs
                v-model="activeTab"
                :color="Color.PRIMARY">
                <!--ANSWER LIST-->
                <BaseTab title="Réponses">
                    <!--MCQ && SURVEY-->
                    <div v-if="isDisplayed">
                        <AnswersSimple
                            :question-choice="questionDisplayed"
                            :answers="answersDisplayed" />
                    </div>
                    <AnswersBarChart
                        v-if="
                            (currentInteraction.type === InteractionType.MCQ ||
                                currentInteraction.type === InteractionType.SURVEY) &&
                            !isDisplayed
                        "
                        @display="displayDetails" />

                    <!--TEXT-->
                    <div v-if="currentInteraction.type === InteractionType.TEXT">
                        <p class="font-light">
                            Cliquez sur les réponses que vous souhaitez épingler en haut de la liste.
                        </p>
                        <AnswersList />
                    </div>
                </BaseTab>

                <!--SELECT MANUALLY-->
                <BaseTab
                    v-if="currentInteraction.type === InteractionType.TEXT"
                    title="Sélection manuelle">
                    <!--TEXT-->
                    <AnswersSelectManual />
                </BaseTab>

                <!--SELECT RANDOM-->
                <BaseTab
                    title="Sélection aléatoire"
                    :active="true">
                    <!--MCQ  random parmi les corrects -> pseudo des gagnants qui ont répondu juste-->

                    <!--SURVEY  pseudo des gagnant random + n° de la question? -->
                    <!--TEXT  pseudo des gagnant random + contenu text -->
                    <p class="font-light">
                        Entrez le nombre d'auditeurs que vous souhaitez faire gagner aléatoirement.
                    </p>
                    <AnswersSelectRandom />
                </BaseTab>

                <!--SELECT FIRSTS-->
                <BaseTab
                    v-if="currentInteraction.type === InteractionType.MCQ"
                    title="Sélection des premiers">
                    <div>
                        <p class="font-light">Entrez le nombre d'auditeurs que vous souhaitez faire gagner.</p>
                        <p class="font-light">
                            Cela sélectionne les plus rapides ayant répondu à la question correctement.
                        </p>
                        <AnswersSelectFastest />
                    </div>
                </BaseTab>
            </BaseTabs>
        </template>
        <template #actions>
            <div class="flex flex-row gap-3">
                <!--BACK TO BAR CHART-->
                <BaseButton
                    v-if="isDisplayed && activeTab === 0"
                    :color="`${Color.PRIMARY}`"
                    @click="hideDetails()">
                    Retour
                </BaseButton>
                <!--END INTERACTION-->
                <BaseButton
                    v-else
                    type="submit"
                    @click="interactionStore.endInteraction()">
                    Fin de l'interaction
                </BaseButton>

                <!--CONFIRM MANUAL-->
                <BaseButton
                    v-if="activeTab === 1 && currentInteraction.type === InteractionType.TEXT"
                    type="submit"
                    :color="Color.PRIMARY"
                    @click="interactionStore.submitManual()">
                    Confirmer
                </BaseButton>

                <!--CONFIRM RANDOM-->
                <BaseButton
                    v-if="
                        (activeTab === 1 &&
                            (currentInteraction.type === InteractionType.MCQ ||
                                currentInteraction.type === InteractionType.SURVEY)) ||
                        (activeTab === 2 && currentInteraction.type === InteractionType.TEXT)
                    "
                    type="submit"
                    :color="Color.PRIMARY"
                    @click="interactionStore.submitRandom()">
                    Confirmer
                </BaseButton>

                <!--CONFIRM FASTEST-->
                <BaseButton
                    v-if="activeTab === 2 && currentInteraction.type === InteractionType.MCQ"
                    type="submit"
                    :color="Color.PRIMARY"
                    @click="interactionStore.submitFastest()">
                    Confirmer
                </BaseButton>
            </div>
        </template>
    </BaseCard>
</template>

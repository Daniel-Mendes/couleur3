<script lang="ts" setup>
import { useInteractionStore } from "@/scripts/stores/useInteractionStore.js";
import { storeToRefs } from "pinia";

defineEmits<{
    display: (questionChoice: App.Data.QuestionChoiceData, answers: App.Data.AnswerData[]) => void;
}>();
const interactionStore = useInteractionStore();
const { currentInteraction } = storeToRefs(interactionStore);
import { ref, computed } from "vue";

const barMaxHeight = 220;
const questionChoices = ref(currentInteraction.value.question_choices);

const getBarColor = (questionChoice) => {
    return questionChoice.is_correct_answer ? "primary" : "white";
};
const getQuestionChoiceAnswers = (questionChoice: App.Data.QuestionChoiceData) => {
    return currentInteraction.value.answers.filter(
        (answer: App.Data.AnswerData) => answer.replyable_id === questionChoice.id
    );
};
/*
let maxValue = 0;
questionChoices.value.forEach((questionChoice) => {
    if (getQuestionChoiceAnswers(questionChoice).length > maxValue) {
        maxValue = getQuestionChoiceAnswers(questionChoice).length;
    }
});
*/

const maxValue = computed(() => {
    let max = 0;
    questionChoices.value.forEach((questionChoice) => {
        const choiceAnswers = getQuestionChoiceAnswers(questionChoice);
        if (choiceAnswers.length > max) {
            max = choiceAnswers.length;
        }
    });
    return max;
});
const getHeights = (questionChoice) => {
    const questionChoiceValue = getQuestionChoiceAnswers(questionChoice).length;
    if (maxValue.value !== 0) {
        return (questionChoiceValue / maxValue.value) * (barMaxHeight - 50) + 50;
    } else {
        return 50;
    }
};
</script>

<template>
    <p class="font-light">Cliquez sur les barres pour voir le détail des participants.</p>
    <div :class="`mt-5 flex h-[220px] flex-row items-end gap-3`">
        <div
            v-for="(questionChoice, i) of questionChoices"
            :id="questionChoice.id"
            :key="questionChoice.id"
            :style="`height: ${getHeights(questionChoice)}px`"
            class="bar"
            :class="`grid grid-cols-1 bg-${getBarColor(
                questionChoice
            )} w-full content-between justify-items-center rounded-t-[20px] bg-opacity-50 hover:bg-opacity-75`"
            @click="$emit('display', questionChoice, getQuestionChoiceAnswers(questionChoice))">
            <div>
                Nb de réponses:
                {{ getQuestionChoiceAnswers(questionChoice).length }}
            </div>
            <div class="text-md mx-2 text-center font-bold text-[#1c1354]">Réponse {{ i + 1 }}</div>
        </div>
    </div>
    <div :class="`mt-1 flex flex-row gap-3`">
        <div
            v-for="questionChoice of questionChoices"
            :id="questionChoice.id"
            :key="questionChoice.id"
            class="mx-1 grid w-full grid-cols-1 text-center text-sm font-light text-white">
            <div>{{ questionChoice.value }}</div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref, computed } from "vue";
import InteractionType from "@/scripts/enums/InteractionType.js";
import { useInteractionStore } from "@/scripts/stores/useInteractionStore.js";
import { storeToRefs } from "pinia";
import { router } from "@inertiajs/vue3";

const interactionStore = useInteractionStore();
const { currentInteraction, hasAnswerd } = storeToRefs(interactionStore);

const isDisabled = ref(false);
const statsChoices = computed(() => {
    const answers = currentInteraction.value.answers;
    if (answers) {
        const total = answers.length;
        const count = [];
        const percentage = [];
        currentInteraction.value.question_choices.forEach((choice) => {
            count.push({ id: choice.id, nb: 0 });
        });
        answers.forEach((answer) => {
            count.forEach((element) => {
                if (element.id === answer.replyable.id) {
                    element.nb++;
                    return;
                }
            });
        });
        for (let i = 0; i < count.length; i++) {
            percentage.push(Math.round((count[i].nb * 100) / total));
        }
        return percentage;
    } else {
        return [100, 100, 100, 100];
    }
});

function responseAuditor(choiceId) {
    submit(choiceId);
    hasAnswerd.value = true;
    // change la taille des résultats
    const container = document.querySelector(".container");

    statsChoices.value.forEach((stat, index) => {
        container.style.setProperty(`--right-${index + 1}`, `${100 - stat}%`);
    });

    // désactive les réponses
    isDisabled.value = true;
}

const submit = (choiceId) => {
    router.post(
        route(`interactions.answers.${currentInteraction.value.type.toLowerCase()}.store`, currentInteraction.value.id),
        {
            questionChoiceChosed: choiceId,
        }
    );
};
</script>

<template>
    <form
        class="container flex flex-col gap-y-3"
        @submit.prevent="submit">
        <div
            v-for="(choice, index) in currentInteraction.question_choices"
            :key="choice.id">
            <input
                :id="'choice-' + index"
                type="radio"
                class="hidden"
                name="SurveyMCQ"
                :disabled="isDisabled || hasAnswerd"
                :value="choice.value"
                @change="responseAuditor(choice.id)" />
            <label
                :for="'choice-' + index"
                class="choiceButton relative flex h-12 items-center overflow-hidden rounded-3xl bg-base-100/50 px-3.5">
                <span
                    v-if="currentInteraction.type === InteractionType.MCQ"
                    class="propositionSolution">
                    <span
                        v-if="(hasAnswerd || isDisabled) && choice.is_correct_answer === 0"
                        class="material-symbols-rounded align-middle">
                        close
                    </span>
                    <span
                        v-if="(hasAnswerd || isDisabled) && choice.is_correct_answer === 1"
                        class="material-symbols-rounded align-middle">
                        done
                    </span>
                </span>
                <span>{{ choice.value }}</span>
                <span class="answers">
                    <span v-if="isDisabled || hasAnswerd">{{ statsChoices[index] }}%</span>
                </span>
            </label>
        </div>
    </form>
</template>
<style scoped>
.container {
    --right-1: 100%;
    --right-2: 100%;
    --right-3: 100%;
    --right-4: 100%;
}
.container label {
    justify-content: center;
}
.container input:disabled ~ label {
    background-color: transparent;
    justify-content: space-between;
}
/* fond réponse question */
.container label::before,
.container label::after {
    content: "";
    border-radius: inherit;
    position: absolute;
    z-index: -1;
    top: 0;
    left: 0;
    bottom: 0;
    background-color: transparent;
}
.container label::before {
    right: 0;
}
.container label::after {
    right: 100%;
    transition: right 0.8s ease-in-out;
}
.container div:nth-of-type(1) input:disabled ~ label::after {
    right: var(--right-1);
}
.container div:nth-of-type(2) input:disabled ~ label::after {
    right: var(--right-2);
}
.container div:nth-of-type(3) input:disabled ~ label::after {
    right: var(--right-3);
}
.container div:nth-of-type(4) input:disabled ~ label::after {
    right: var(--right-4);
}

.container input:disabled:checked ~ label::after {
    background-color: #ffe27c;
}

.container input:disabled ~ label::before {
    background-color: #ffffff80;
}
.container input:disabled ~ label::after {
    background-color: #fff;
}
/* Texte réponse question */
.container label > span.propositionSolution,
.container label > span.answers {
    transition: transform 0.4s ease-in-out;
}
.container label > span.propositionSolution {
    transform: translateX(-60px);
}
.container label > span.answers {
    transform: translateX(90px);
}
.container input:disabled ~ label > span.propositionSolution,
.container input:disabled ~ label > span.answers {
    transform: translateX(0px);
}
</style>

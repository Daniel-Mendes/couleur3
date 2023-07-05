<script setup>
import TextInput from "@/Components/TextInput.vue";
import InputGroup from "@/Components/InputGroup.vue";
import InputError from "@/Components/InputError.vue";
import MultipleInputGroup from "@/Components/Animator/Bases/MultipleInputGroup.vue";
import BaseCard from "@/Components/Animator/Bases/BaseCard.vue";
import BaseButton from "@/Components/Animator/Bases/BaseButton.vue";
import BaseRadioGroup from "@/Components/Animator/Bases/BaseRadioGroup.vue";
import BaseDurationRange from "@/Components/Animator/Bases/BaseDurationRange.vue";
import Color from "@/Enums/Color.js";
import InteractionType from "@/Enums/InteractionType.js";
import QuestionType from "@/Enums/QuestionType.js";
import { watch, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useInteractionStore } from "@/Stores/useInteractionStore.js";
import { storeToRefs } from "pinia";

const interactionStore = useInteractionStore();
const { isCreatingInteraction } = storeToRefs(interactionStore);

const correctAnswer = ref(null);
const form = useForm({
    type: null,
    title: "",
    duration: 300,

    question_choices: [
        {
            value: "",
            is_correct_answer: correctAnswer?.value === 0,
        },
        {
            value: "",
            is_correct_answer: correctAnswer?.value === 1,
        },
        {
            value: "",
            is_correct_answer: correctAnswer?.value === 2,
        },
        {
            value: "",
            is_correct_answer: correctAnswer?.value === 3,
        },
    ],
});

watch(correctAnswer, (newValue) => {
    form.question_choices.forEach((question_choice, index) => {
        question_choice.is_correct_answer = newValue === index;
    });
});

const submit = () => {
    form.post(route(`interactions.${isCreatingInteraction.value?.toLowerCase()}.store`), {
        onSuccess: () => {
            form.reset();
            interactionStore.createdInteraction();
        },
    });
};

const cancelQuestionType = () => {
    form.reset();
    form.clearErrors();
    interactionStore.cancelInteraction();

    // Remove the selected radio button
    const radioButtons = document.getElementsByName("questionTypes");
    radioButtons.forEach((radioButton) => {
        radioButton.checked = false;
    });
};
</script>

<template>
    <!-- Dashboard card && Create form -->
    <form
        class="overflow-y-scroll scrollbar-thin scrollbar-thumb-primary scrollbar-thumb-rounded"
        @submit.prevent="submit">
        <BaseCard :color="Color.PRIMARY">
            <template #title>Question</template>
            <template #content>
                <BaseRadioGroup
                    v-model="form.type"
                    :choices="QuestionType.getAll()"
                    name="questionTypes"
                    @input="interactionStore.creatingInteraction(form.type)" />

                <div
                    v-if="isCreatingInteraction"
                    class="mt-5 flex flex-col gap-6">
                    <InputGroup
                        v-if="
                            form.type === InteractionType.MCQ ||
                            form.type === InteractionType.SURVEY ||
                            form.type === InteractionType.TEXT
                        "
                        id="question"
                        label="Question">
                        <TextInput
                            id="question"
                            v-model="form.title"
                            :color="Color.PRIMARY" />
                        <InputError
                            class="mt-2"
                            :message="form.errors.title" />
                    </InputGroup>

                    <InputGroup
                        v-else
                        id="title"
                        label="Titre">
                        <TextInput
                            id="title"
                            v-model="form.title"
                            :color="Color.PRIMARY" />
                        <InputError
                            class="mt-2"
                            :message="form.errors.title" />
                    </InputGroup>

                    <MultipleInputGroup
                        v-if="form.type === InteractionType.MCQ || form.type === InteractionType.SURVEY"
                        :form-type="form.type">
                        <template
                            v-if="form.type === InteractionType.SURVEY"
                            #instructions>
                            Entrez les réponses que les auditeurs pourraient répondre.
                            <InputError
                                class="mt-2"
                                :message="form.errors.question_choices" />
                        </template>
                        <template
                            v-else
                            #instructions>
                            Entrez les réponses que les auditeurs pourraient répondre. Cochez la réponse correcte.
                            <InputError
                                class="mt-2"
                                :message="form.errors.question_choices" />
                        </template>
                        <template #input1>
                            <div class="flex flex-row items-center gap-3">
                                <input
                                    v-if="form.type === InteractionType.MCQ"
                                    v-model="correctAnswer"
                                    :value="0"
                                    type="radio"
                                    name="mcq"
                                    class="checkbox-primary checkbox checkbox-lg bg-transparent"
                                    @change="correctAnswer = 0" />
                                <TextInput
                                    id="input-1"
                                    v-model="form.question_choices[0].value"
                                    :color="Color.PRIMARY" />
                            </div>
                        </template>
                        <template #input2>
                            <div class="flex flex-row items-center gap-3">
                                <input
                                    v-if="form.type === InteractionType.MCQ"
                                    v-model="correctAnswer"
                                    :value="1"
                                    type="radio"
                                    name="mcq"
                                    class="checkbox-primary checkbox checkbox-lg bg-transparent"
                                    @change="correctAnswer = 1" />
                                <TextInput
                                    id="input-2"
                                    v-model="form.question_choices[1].value"
                                    :color="Color.PRIMARY" />
                            </div>
                        </template>
                        <template #input3>
                            <div class="flex flex-row items-center gap-3">
                                <input
                                    v-if="form.type === InteractionType.MCQ"
                                    v-model="correctAnswer"
                                    :value="2"
                                    type="radio"
                                    name="mcq"
                                    class="checkbox-primary checkbox checkbox-lg bg-transparent"
                                    @change="correctAnswer = 2" />
                                <TextInput
                                    id="input-3"
                                    v-model="form.question_choices[2].value"
                                    :color="Color.PRIMARY" />
                            </div>
                        </template>
                        <template #input4>
                            <div class="flex flex-row items-center gap-3">
                                <input
                                    v-if="form.type === InteractionType.MCQ"
                                    v-model="correctAnswer"
                                    :value="3"
                                    type="radio"
                                    name="mcq"
                                    class="checkbox-primary checkbox checkbox-lg bg-transparent"
                                    @change="correctAnswer = 3" />
                                <TextInput
                                    id="input-4"
                                    v-model="form.question_choices[3].value"
                                    :color="Color.PRIMARY" />
                            </div>
                        </template>
                    </MultipleInputGroup>

                    <InputGroup
                        id="duration"
                        label="Durée d'interaction">
                        <BaseDurationRange
                            id="duration"
                            v-model="form.duration"
                            :min="15"
                            :color="Color.PRIMARY" />
                    </InputGroup>
                </div>
            </template>
            <template
                v-if="isCreatingInteraction"
                #actions>
                <div class="flex flex-row gap-3">
                    <BaseButton
                        :disabled="form.processing"
                        @click="cancelQuestionType"
                        >Annuler</BaseButton
                    >
                    <BaseButton
                        :color="Color.PRIMARY"
                        :disabled="form.processing"
                        type="submit"
                        >Envoyer</BaseButton
                    >
                </div>
            </template>
        </BaseCard>
    </form>
</template>

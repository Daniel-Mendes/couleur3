<script lang="ts" setup>
import Color from "@/scripts/enums/Color.js";

withDefaults(
    defineProps<{
        questionChoice: App.Data.QuestionChoiceData;
        answers: App.Data.AnswerData[];
    }>(),
    {
        answers: null,
    }
);
</script>
<template>
    <p class="font-light">
        Participants ayant répondu à :
        <span class="font-bold">{{ questionChoice.value }}</span>
    </p>
    <div :class="`mt-8 h-56 overflow-x-auto scrollbar-thin scrollbar-thumb-rounded scrollbar-thumb-${Color.PRIMARY}`">
        <table class="grid grid-cols-3 gap-2">
            <tbody
                v-for="answer of answers"
                :key="answer.id"
                :for="answer.id">
                <tr class="border-none">
                    <td class="text-base font-bold">
                        <slot>{{ answer.auditor.user.name }}</slot>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <p class="mt-4 font-light">{{ answers.length }} réponses</p>
</template>

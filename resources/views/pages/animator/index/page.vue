<!-- eslint-disable no-undef -->
<script lang="ts" setup>
import BaseButton from "@/Components/Animator/Bases/BaseButton.vue";
import ChatView from "@/Components/Animator/Chat/ChatView.vue";
import QuickClickIndex from "@/Components/Animator/QuickClick/QuickClickIndex.vue";
import QuickClickCreate from "@/Components/Animator/QuickClick/QuickClickCreate.vue";
import QuickClickShow from "@/Components/Animator/QuickClick/QuickClickShow.vue";
import CtaIndex from "@/Components/Animator/Cta/CtaIndex.vue";
import CtaCreate from "@/Components/Animator/Cta/CtaCreate.vue";
import CtaShow from "@/Components/Animator/Cta/CtaShow.vue";
import QuestionCreate from "@/Components/Animator/Question/QuestionCreate.vue";
import QuestionShow from "@/Components/Animator/Question/QuestionShow.vue";
import InteractionType from "@/Enums/InteractionType.js";
import EndingMessage from "@/Components/Animator/Answers/EndingMessage.vue";
import { route } from "momentum-trail";
import { Head, router } from "@inertiajs/vue3";
import { useInteractionStore } from "@/stores/useInteractionStore.js";
import { storeToRefs } from "pinia";

const interactionStore = useInteractionStore();
const { isCreatingInteraction, currentInteraction } = storeToRefs(interactionStore);

const endEmission = () => {
    router.post(route("animator.endEmission"));
};
</script>

<template>
    <Head title="Dashboard" />
    <div
        id="animator-container"
        class="flex h-screen max-h-screen gap-5 p-5">
        <div class="flex max-h-full flex-auto basis-1/3 flex-col gap-3">
            <ChatView class="flex-auto" />

            <BaseButton
                color="error"
                class="btn-block btn-lg flex-initial bg-opacity-50 text-white"
                @click="endEmission">
                Fin d'émission
            </BaseButton>
        </div>

        <div class="flex basis-2/3 flex-col gap-3">
            <template
                v-if="
                    !currentInteraction && (!isCreatingInteraction || InteractionType.isQuestion(isCreatingInteraction))
                ">
                <QuestionCreate />
            </template>

            <template v-if="!isCreatingInteraction && !currentInteraction">
                <CtaIndex />
                <QuickClickIndex />
            </template>

            <QuickClickCreate v-if="isCreatingInteraction == InteractionType.QUICK_CLICK" />
            <CtaCreate v-if="isCreatingInteraction === InteractionType.CTA" />

            <QuickClickShow
                v-if="
                    currentInteraction &&
                    currentInteraction.type === InteractionType.QUICK_CLICK &&
                    currentInteraction.winners &&
                    currentInteraction.winners.length === 0
                " />
            <CtaShow
                v-if="
                    currentInteraction &&
                    currentInteraction.type === InteractionType.CTA &&
                    currentInteraction.winners &&
                    currentInteraction.winners.length === 0
                " />
            <QuestionShow
                v-if="
                    currentInteraction &&
                    InteractionType.isQuestion(currentInteraction.type) &&
                    currentInteraction.winners &&
                    currentInteraction.winners.length === 0
                " />

            <EndingMessage
                v-if="currentInteraction && currentInteraction.winners && currentInteraction.winners.length > 0" />
        </div>
    </div>
</template>

<style lang="postcss" scoped>
.v-enter-active,
.v-leave-active {
    transition: all 0.4s ease;
}

.v-enter-from,
.v-leave-to {
    transform: translateX(100px);
    opacity: 0;
}

#animator-container {
    background-color: #1c1354;
}
</style>

<script lang="ts" setup>
import BaseButton from "@/views/components/Animator/Bases/BaseButton.vue";
import ChatView from "@/views/components/Animator/Chat/ChatView.vue";
import QuickClickIndex from "@/views/components/Animator/QuickClick/QuickClickIndex.vue";
import QuickClickCreate from "@/views/components/Animator/QuickClick/QuickClickCreate.vue";
import QuickClickShow from "@/views/components/Animator/QuickClick/QuickClickShow.vue";
import CtaIndex from "@/views/components/Animator/Cta/CtaIndex.vue";
import CtaCreate from "@/views/components/Animator/Cta/CtaCreate.vue";
import CtaShow from "@/views/components/Animator/Cta/CtaShow.vue";
import QuestionCreate from "@/views/components/Animator/Question/QuestionCreate.vue";
import QuestionShow from "@/views/components/Animator/Question/QuestionShow.vue";
import InteractionType from "@/enums/InteractionType.js";
import EndingMessage from "@/views/components/Animator/Answers/EndingMessage.vue";
import { useInteractionStore } from "@/scripts/stores/useInteractionStore.js";

const interactionStore = useInteractionStore();
const { isCreatingInteraction, currentInteraction } = storeToRefs(interactionStore);

const endEmission = () => {
    router.post(route("animator.endEmission"));
};

console.log(isCreatingInteraction);
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

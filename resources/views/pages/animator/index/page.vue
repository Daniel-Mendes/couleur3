<script lang="ts" setup>
import BaseButton from "@/views/components/animator/basics/BaseButton.vue";
import ChatView from "./partials/chat/ChatView.vue";
import QuickClickIndex from "./partials/quick-click/QuickClickIndex.vue";
import QuickClickCreate from "./partials/quick-click/QuickClickCreate.vue";
import QuickClickShow from "./partials/quick-click/QuickClickShow.vue";
import CtaIndex from "./partials/cta/CtaIndex.vue";
import CtaCreate from "./partials/cta/CtaCreate.vue";
import CtaShow from "./partials/cta/CtaShow.vue";
import QuestionCreate from "./partials/question/QuestionCreate.vue";
import QuestionShow from "./partials/question/QuestionShow.vue";
import InteractionType from "@/scripts/enums/InteractionType.js";
import EndingMessage from "./partials/answers/EndingMessage.vue";
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

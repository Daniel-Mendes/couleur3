<script lang="ts" setup>
import BaseCheckbox from "@/views/components/animator/basics/BaseCheckbox.vue";
import SelectReward from "./SelectReward.vue";
import Color from "@/scripts/enums/Color.js";
import { calculateDuration, formatDuration } from "@/scripts/utils/time.js";
import { useInteractionStore } from "@/scripts/stores/useInteractionStore.js";
import { storeToRefs } from "pinia";
import { ref } from "vue";

const interactionStore = useInteractionStore();
const { pinnedAnswers, notPinnedAnswers, currentInteraction, chosedWinners } = storeToRefs(interactionStore);

const pinnedCandidates = ref(pinnedAnswers);
const candidates = ref(notPinnedAnswers);
</script>

<template>
    <div>
        <div class="items-top flex flex-row justify-between">
            <div class="grow">
                <p class="font-light">Sélectionnez les réponses que vous souhaitez faire gagner.</p>
            </div>
            <div class="flex shrink flex-row">
                <p class="w-24 text-sm font-light">Sélectionner toutes les épingles</p>
                <BaseCheckbox
                    :color="Color.forInteractionType(currentInteraction.type)"
                    @change="interactionStore.updatePinnedAsChosedWinners(pinnedCandidates)" />
            </div>
        </div>

        <div class="mt-4 h-[22vh] overflow-x-auto pl-1 pt-1">
            <div>
                <!-- Array pinned -->
                <ul class="flex flex-col gap-4">
                    <li
                        v-for="pinnedCandidate of pinnedCandidates"
                        :key="pinnedCandidate.id"
                        class="text-md flex flex-row items-center gap-2">
                        <BaseCheckbox
                            :color="Color.forInteractionType(currentInteraction.type)"
                            :checked="chosedWinners.length > 0 && chosedWinners.indexOf(pinnedCandidate) != -1"
                            class="mr-1"
                            @change="interactionStore.updateChosedWinner(pinnedCandidate)" />

                        <div class="font-bold">
                            {{ pinnedCandidate.auditor.user.name }}
                        </div>

                        <div class="text-base">
                            a répondu en
                            {{
                                formatDuration(
                                    calculateDuration(pinnedCandidate.created_at, currentInteraction.created_at)
                                )
                            }}
                        </div>

                        <div
                            :class="`material-symbols-fill material-symbols-rounded fill-current text-2xl font-thin text-${Color.forInteractionType(
                                currentInteraction.type
                            )}`">
                            push_pin
                        </div>
                    </li>
                </ul>
            </div>
            <div>
                <!-- Array not pinned -->
                <ul class="flex flex-col gap-4">
                    <li
                        v-for="candidate of candidates"
                        :key="candidate.value"
                        :for="candidate.value"
                        class="text-md flex flex-row items-center gap-2">
                        <BaseCheckbox
                            :color="Color.forInteractionType(currentInteraction.type)"
                            :checked="chosedWinners.length > 0 && chosedWinners.indexOf(candidate) != -1"
                            class="mr-1"
                            @change="interactionStore.updateChosedWinner(candidate)" />

                        <div class="font-bold">
                            {{ candidate.auditor.user.name }}
                        </div>

                        <div class="text-base">
                            {{ formatDuration(calculateDuration(candidate.created_at, currentInteraction.created_at)) }}
                        </div>

                        <div
                            :class="`material-symbols-rounded fill-current text-2xl font-thin text-${Color.forInteractionType(
                                currentInteraction.type
                            )}`">
                            push_pin
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <SelectReward class="mt-4" />
    </div>
</template>

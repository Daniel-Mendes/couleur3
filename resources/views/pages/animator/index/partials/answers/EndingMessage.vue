<script lang="ts" setup>
import BaseCard from "@/views/components/animator/basics/BaseCard.vue";
import BaseButton from "@/views/components/animator/basics/BaseButton.vue";
import Color from "@/scripts/enums/Color";
import InteractionType from "@/scripts/enums/InteractionType";
import { useInteractionStore } from "@/scripts/stores/useInteractionStore.js";
import { calculateDuration, formatDuration } from "@/scripts/utils/time.js";
import { storeToRefs } from "pinia";

const interactionStore = useInteractionStore();
const { currentInteraction } = storeToRefs(interactionStore);
</script>
<template>
    <!-- Message du CTA -->
    <template v-if="currentInteraction.type === InteractionType.CTA">
        <h2>Merci !</h2>
    </template>
    <template v-if="currentInteraction.type !== InteractionType.CTA">
        <BaseCard :color="Color.forInteractionType(currentInteraction.type)">
            <template #title> Merci ! </template>
            <template #subtitle> Un message a été envoyé aux gagnants suivant :</template>
            <template #content>
                <ul
                    :class="`max-h-[55vh] overflow-y-scroll scrollbar-thin scrollbar-thumb-rounded scrollbar-thumb-${Color.forInteractionType(
                        currentInteraction.type
                    )} flex flex-col gap-2`">
                    <li
                        v-for="winner of currentInteraction.winners"
                        :key="winner.id"
                        class="flex">
                        <div class="pr-5 font-bold">
                            {{ winner.auditor.user.name }}
                        </div>
                        <!-- Quick Click -> Durée de réponse -->
                        <template v-if="currentInteraction.type === InteractionType.QUICK_CLICK">
                            <div>
                                a répondu en
                                {{
                                    formatDuration(
                                        calculateDuration(
                                            currentInteraction.answers.filter(
                                                (answer) => winner.auditor_id === answer.auditor_id
                                            )[0].created_at,
                                            currentInteraction.created_at
                                        )
                                    )
                                }}
                            </div>
                        </template>
                        <!-- Text -> Contenu -->
                        <template v-if="currentInteraction.type === InteractionType.TEXT"
                            ><div class="pr-5">a répondu</div>
                            <div>
                                "{{
                                    currentInteraction.answers.filter(
                                        (answer) => winner.auditor_id === answer.auditor_id
                                    )[0].replyable.content
                                }}"
                            </div>
                        </template>
                    </li>
                </ul>
                <p class="font-light">{{ currentInteraction.winners.length }} gagnants</p>
            </template>
            <template #actions>
                <BaseButton
                    :color="Color.forInteractionType(currentInteraction.type)"
                    @click="interactionStore.endInteraction()">
                    Retour à l'accueil
                </BaseButton>
            </template>
        </BaseCard>
    </template>
</template>

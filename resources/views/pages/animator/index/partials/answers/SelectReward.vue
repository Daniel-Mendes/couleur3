<script lang="ts" setup>
import InputGroup from "@/views/components/InputGroup.vue";
import Color from "@/scripts/enums/Color";
import { useInteractionStore } from "@/scripts/stores/useInteractionStore";
import { storeToRefs } from "pinia";

const interactionStore = useInteractionStore();
const { currentInteraction, rewards, chosedReward } = storeToRefs(interactionStore);
</script>
<template>
    <InputGroup
        id="select-rewards"
        label="Lot remporté">
        <select
            id="select-rewards"
            :class="`select-bordered select select-md w-full max-w-xs rounded-full bg-transparent focus:border-${Color.forInteractionType(
                currentInteraction.type
            )}  focus:ring-${Color.forInteractionType(currentInteraction.type)} font-light`"
            @change="chosedReward = Number($event.target.value)">
            <option
                class="bg-neutral-200"
                disabled
                selected>
                Sélectionnez un lot
            </option>
            <option
                v-for="reward of rewards"
                id="color"
                :key="reward.id"
                :value="reward.id"
                :for="reward.id"
                :class="`text-black bg-${Color.forInteractionType(currentInteraction.type)} bg-opacity-50`">
                {{ reward.name }}
            </option>
        </select>
    </InputGroup>
</template>

<style lang="postcss" scoped>
option:checked,
option:hover {
    @apply bg-opacity-100 !important;
}
</style>

<script lang="ts" setup>
import InputGroup from "@/views/components/InputGroup.vue";
import TextInput from "@/views/components/TextInput.vue";
import InputError from "@/views/components/InputError.vue";
import SelectReward from "./SelectReward.vue";
import { useInteractionStore } from "@/scripts/stores/useInteractionStore.js";
import { storeToRefs } from "pinia";
import Color from "@/scripts/enums/Color.js";

const interactionStore = useInteractionStore();
const { currentInteraction, winnersCount, errors } = storeToRefs(interactionStore);
</script>

<template>
    <div>
        <div class="mt-4 flex h-[29vh] flex-col gap-4">
            <InputGroup
                id="winners-count"
                label="Nombre de gagnants">
                <TextInput
                    id="winners-count"
                    type="number"
                    :color="Color.forInteractionType(currentInteraction.type)"
                    :min="1"
                    :max="currentInteraction.answers.length"
                    :value="winnersCount"
                    @change="winnersCount = Number($event.target.value)" />

                <InputError
                    class="mt-2"
                    :message="errors.winners_count" />
            </InputGroup>
        </div>
    </div>
    <SelectReward />
</template>

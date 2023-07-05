<script lang="ts" setup>
import { useInteractionStore } from "@/scripts/stores/useInteractionStore.js";
import { storeToRefs } from "pinia";

defineProps<{
    id: string;
}>();
const interactionStore = useInteractionStore();
const { hasOpenedNotif } = storeToRefs(interactionStore);
</script>

<template>
    <div
        :id="id"
        class="chat chat-start cursor-pointer self-start px-3.5 py-2">
        <div class="chat-image avatar">
            <div class="w-10 rounded-full bg-base-100">
                <img
                    src="images/Bulle-COULEUR3.svg"
                    alt="Logo Couleur 3" />
            </div>
        </div>
        <div class="gradient-auditor chat-bubble relative max-w-none text-lg font-bold text-black">
            <slot />
            <div
                v-if="!hasOpenedNotif"
                class="indicator absolute right-0 top-0 mr-1 mt-1">
                <span class="badge indicator-item border-info bg-info"></span>
                <div class="grid h-32 w-32"></div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.gradient-auditor::before {
    background-color: #ff67ff;
}
</style>

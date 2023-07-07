<script lang="ts" setup>
import { computed, Ref } from "vue";

withDefaults(
    defineProps<{
        min: number;
        max: number;
        step: number;
        color: string;
    }>(),
    {
        min: 0,
        max: 3600,
        step: 15,
        color: "primary",
    }
);

const modelValue: Ref<number> = defineModel();

const formatedMinutes = computed(() => {
    return Math.floor(modelValue.value / 60);
});

const formatedSeconds = computed(() => {
    return modelValue.value % 60;
});
</script>

<template>
    <div class="flex w-full items-center gap-8">
        <div class="flex flex-auto flex-col">
            <input
                id="duration"
                v-model="modelValue"
                type="range"
                :class="`range range-lg range-${color}`"
                :min="min"
                :max="max"
                :step="step" />
            <ul
                id="range-labels"
                class="flex w-full justify-between px-2 text-xs">
                <li>0min</li>
                <li>15min</li>
                <li>30min</li>
                <li>45min</li>
                <li>60min</li>
            </ul>
        </div>
        <div class="w-200 flex flex-row items-center gap-3 text-center text-base text-white">
            <div :class="`flex flex-col items-center p-4 bg-${color} rounded-[20px] bg-opacity-25 font-normal`">
                <span class="font-medium">
                    <span>{{ formatedMinutes }}</span>
                </span>
                min
            </div>
            <span>:</span>
            <div :class="`flex flex-col items-center p-4 bg-${color} rounded-[20px] bg-opacity-25 font-normal`">
                <span class="font-medium">
                    <span>{{ formatedSeconds }}</span>
                </span>
                sec
            </div>
        </div>
    </div>
</template>

<style scoped>
#range-labels li {
    position: relative;
    margin-top: 0.2rem;
}
</style>

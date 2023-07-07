<template>
    <div :class="`card bg-${color} bg-opacity-25 text-white`">
        <div class="card-body">
            <h2
                v-if="$slots.title"
                class="card-title text-3xl font-bold">
                <slot name="title" />
            </h2>
            <div
                v-if="$slots.subtitle"
                class="mt-1 font-light">
                <slot name="subtitle" />
            </div>
            <div
                v-if="$slots.content"
                class="mt-8 flex flex-auto flex-col gap-3">
                <slot name="content" />
            </div>
            <div
                v-if="$slots.actions"
                class="card-actions mt-8 justify-center">
                <slot name="actions" />
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import Color from "@/scripts/enums/Color.js";

withDefaults(
    defineProps<{
        color: string;
    }>(),
    {
        color: Color.WHITE,
    }
);
</script>

<script lang="ts" setup>
import InputLabel from "@/views/components/InputLabel.vue";

withDefaults(
    defineProps<{
        label: string;
        id: string;
    }>(),
    {
        label: "Label",
        id: "",
    }
);
</script>

<template>
    <div class="flex flex-col gap-2">
        <InputLabel :for="id">{{ label }}</InputLabel>

        <div class="flex flex-auto flex-col">
            <slot></slot>
        </div>
    </div>
</template>

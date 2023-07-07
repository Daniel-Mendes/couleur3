<script lang="ts" setup>
import InputGroup from "@/views/components/InputGroup.vue";
</script>

<template>
    <div class="flex flex-col gap-3">
        <div class="mt-1 font-light">
            <slot name="instructions"></slot>
        </div>
        <div class="flex w-full flex-row gap-10">
            <InputGroup
                id="input-1"
                class="flex-auto flex-row"
                label="Réponse 1">
                <slot name="input1"></slot>
            </InputGroup>

            <InputGroup
                id="input-2"
                class="flex-auto flex-row"
                label="Réponse 2">
                <slot name="input2"></slot>
            </InputGroup>
        </div>
        <div class="flex w-full flex-row gap-10">
            <InputGroup
                id="input-3"
                class="flex-auto flex-row"
                label="Réponse 3">
                <slot name="input3"></slot>
            </InputGroup>

            <InputGroup
                id="input-4"
                class="flex-auto flex-row"
                label="Réponse 4">
                <slot name="input4"></slot>
            </InputGroup>
        </div>
    </div>
</template>

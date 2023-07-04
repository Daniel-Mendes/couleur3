<script setup>
import InputGroup from "@/Components/InputGroup.vue";
</script>

<template>
    <div class="flex flex-col gap-3">
        <div class="font-light mt-1">
            <slot name="instructions"></slot>
        </div>
        <div class="flex flex-row w-full gap-10">
            <InputGroup
                id="input-1"
                class="flex-row flex-auto"
                label="Réponse 1"
            >
                <slot name="input1"></slot>
            </InputGroup>

            <InputGroup
                id="input-2"
                class="flex-row flex-auto"
                label="Réponse 2"
            >
                <slot name="input2"></slot>
            </InputGroup>
        </div>
        <div class="flex flex-row gap-10 w-full">
            <InputGroup
                id="input-3"
                class="flex-row flex-auto"
                label="Réponse 3"
            >
                <slot name="input3"></slot>
            </InputGroup>

            <InputGroup
                id="input-4"
                class="flex-row flex-auto"
                label="Réponse 4"
            >
                <slot name="input4"></slot>
            </InputGroup>
        </div>
    </div>
</template>

<script lang="ts" setup>
const props = defineProps<{
    icone: {
        type: String;
        required: true;
    };
}>();
</script>

<template>
    <div class="mb-6 flex flex-col">
        <span class="material-symbols-rounded text-center text-8xl">
            {{ props.icone }}
        </span>
        <p class="text-center text-xl font-extrabold">
            <slot />
        </p>
    </div>
</template>

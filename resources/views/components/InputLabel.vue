<script lang="ts" setup>
withDefaults(
    defineProps<{
        id: string;
    }>(),
    {
        id: "",
    }
);
</script>

<template>
    <label
        :for="`${id}`"
        class="block text-lg font-medium text-white">
        <slot></slot>
    </label>
</template>

<template>
    <button :class="`btn btn-${color} btn-wide btn-md rounded-full border-none text-lg`">
        <slot></slot>
    </button>
</template>

<script lang="ts" setup>
withDefaults(
    defineProps<{
        color: string;
    }>(),
    {
        color: "white",
    }
);
</script>

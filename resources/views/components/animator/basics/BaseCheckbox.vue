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

<template>
    <input
        type="checkbox"
        :class="`checkbox checkbox-lg bg-transparent checkbox-${color} focus:outline-${color}`" />
</template>

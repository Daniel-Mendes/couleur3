<script lang="ts" setup>
defineProps<{
    icon: String;
}>();
</script>

<template>
    <div class="mb-6 flex flex-col">
        <span class="material-symbols-rounded text-center text-8xl">
            {{ icon }}
        </span>
        <p class="text-center text-xl font-extrabold">
            <slot />
        </p>
    </div>
</template>

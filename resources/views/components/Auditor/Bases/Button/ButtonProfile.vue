<script lang="ts" setup>
defineProps<{
    outlined: boolean;
}>();
</script>
<template>
    <button
        v-if="outlined"
        class="text-Base inline-flex items-center rounded-full border border-transparent bg-base-100 px-6 py-2 font-normal text-black transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none active:bg-gray-900 dark:hover:bg-white dark:focus:bg-white dark:active:bg-gray-300">
        <slot />
    </button>
    <button
        v-if="!outlined"
        class="mt-16 inline-flex items-center rounded-full border border-white bg-transparent px-6 py-2 text-base font-normal text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none active:bg-gray-900 dark:hover:bg-transparent dark:focus:bg-transparent dark:active:bg-gray-300">
        <slot />
    </button>
</template>

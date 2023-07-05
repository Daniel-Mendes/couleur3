<script lang="ts" setup>
withDefaults(
    defineProps<{
        type: string;
    }>(),
    {
        type: "button",
    }
);
</script>

<template>
    <button
        :type="type"
        class="mt-16 inline-flex items-center rounded-full border border-white bg-transparent px-6 py-2 text-base font-normal text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none active:bg-gray-900 dark:hover:bg-transparent dark:focus:bg-transparent dark:active:bg-gray-300">
        <slot />
    </button>
</template>

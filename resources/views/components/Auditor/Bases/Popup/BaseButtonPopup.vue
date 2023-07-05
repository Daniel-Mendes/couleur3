<script lang="ts" setup>
defineProps<{
    isValidate: Boolean;
}>();
</script>

<template>
    <button
        class="bg-blue-auditor btn-md btn h-9 min-h-0 w-36 rounded-full border-none text-base font-bold text-base-100"
        :disabled="!isValidate">
        <slot />
    </button>
</template>

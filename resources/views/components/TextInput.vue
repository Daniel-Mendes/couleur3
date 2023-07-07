<script lang="ts" setup>
withDefaults(
    defineProps<{
        id: string;
        color?: string;
    }>(),
    {
        color: "primary",
    }
);

const modelValue = defineModel();

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        :id="`${id}`"
        ref="input"
        v-model="modelValue"
        type="text"
        :class="`input-bordered input input-md invalid:border-error invalid:text-error focus:border-2 focus:invalid:border-error focus:invalid:text-error focus:border-${color} w-full rounded-full bg-transparent font-light text-white focus:ring-0`" />
</template>

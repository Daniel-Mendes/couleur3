<script lang="ts" setup>
defineProps<{
    id: {
        type: String;
        required: false;
        default: "";
    };
    label: {
        type: String;
        required: false;
        default: "";
    };
    type: {
        type: String;
        required: false;
        default: "text";
    };
}>();

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
    <label
        class="mb-2 block pl-4 font-bold"
        :for="id"
        >{{ label }}</label
    >
    <input
        :id="id"
        ref="input"
        v-model="modelValue"
        :placeholder="label"
        :type="type"
        class="border-1 input-bordered input input-md w-full rounded-full border-base-100 border-opacity-50 bg-transparent font-light text-white placeholder-base-100 placeholder-opacity-50 invalid:border-error invalid:text-error focus:border-base-100 focus:ring-0 focus:invalid:border-error focus:invalid:text-error" />
</template>

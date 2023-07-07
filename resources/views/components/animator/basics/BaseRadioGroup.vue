<script lang="ts" setup>
defineProps<{
    choices: [];
    name: string;
}>();

defineEmits<{ "update:modelValue": void }>();
</script>
<template class="">
    <div class="grid grid-cols-3 grid-rows-2 gap-3">
        <label
            v-for="choice of choices"
            :key="choice.value"
            :for="choice.value"
            class="btn-white btn-md btn gap-5 rounded-[10px] border-2 border-transparent bg-opacity-50 text-2xl text-white">
            <span class="material-symbols-rounded text-4xl">
                {{ choice.icon }}
            </span>
            <input
                :id="choice.value"
                :value="choice.value"
                :name="name"
                type="radio"
                class="hidden"
                @input="$emit('update:modelValue', choice.value)" />
            <span class="hidden lg:block">{{ choice.name }}</span>
        </label>
    </div>
</template>

<style lang="postcss" scoped>
label:has(input:checked) {
    @apply border-2 border-primary bg-primary bg-opacity-50;
}
</style>

<script lang="ts" setup>
import { computed, provide, reactive } from "vue";
import Color from "@/scripts/enums/Color.js";

withDefaults(
    defineProps<{
        color: {
            type: String;
            default: "primary";
        };
        modelValue: number;
    }>(),
    {
        color: Color.PRIMARY,
        modelValue: 0,
    }
);

const emits = defineEmits<{ "update:modelValue": void }>();

const tabs = reactive({
    labels: [],
    items: [],
    active: 0,
});

const active = computed(() => {
    return tabs.active;
});

provide("tabs", tabs);

function changeTab(i) {
    tabs.active = i;
    emits("update:modelValue", i);
}
</script>

<template>
    <div>
        <ul class="tabs tabs-boxed mb-6">
            <label
                v-for="(label, index) in tabs.labels"
                :key="index"
                :class="`tab ${index === active ? `tab-active tab-active-${color}` : ''}`">
                <input
                    :value="modelValue"
                    type="radio"
                    class="hidden"
                    @click="changeTab(index)" />
                {{ label }}
            </label>
        </ul>
        <slot />
    </div>
</template>

<style lang="postcss" scoped>
.tabs-boxed {
    @apply gap-1 rounded-full bg-white bg-opacity-50;
}
.tab {
    @apply tab-lg flex-auto rounded-full border-2 border-transparent font-bold text-white hover:border-white hover:bg-white hover:bg-opacity-50;
}

.tab-active-primary {
    @apply border-primary bg-[#6BA5BE] !important;
}

.tab-active-secondary {
    @apply border-secondary bg-[#A7A282] !important;
}

.tab-active-accent {
    @apply border-accent bg-[#A766BB] !important;
}

.tab-active {
    @apply border-2 text-white !important;
}
</style>

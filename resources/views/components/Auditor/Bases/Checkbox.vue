<script lang="ts" setup>
import { computed } from "vue";

const props = defineProps<{
    checked: {
        type: [Array, Boolean];
        required: true;
    };
    value: {
        type: Boolean;
        default: false;
    };
}>();

const emit = defineEmits<(e: "update:checked") => void>();

const proxyChecked = computed({
    get() {
        return props.checked;
    },
    set(val) {
        emit("update:checked", val);
    },
});
</script>

<template>
    <input
        v-model="proxyChecked"
        type="checkbox"
        :value="value"
        class="dark:focus:ring-text-base-100 rounded border-base-100 text-black shadow-sm checked:border-base-100 focus:ring-white dark:border-base-100 dark:bg-gray-900 dark:focus:ring-offset-gray-800" />
</template>

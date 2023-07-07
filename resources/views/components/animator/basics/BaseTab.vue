<script lang="ts" setup>
import { inject, onBeforeMount } from "vue";

const props = defineProps<{
    title: string;
    active?: boolean;
}>();

const tabs = inject("tabs");

onBeforeMount(() => {
    tabs.labels.push(props.title);
});
</script>

<template>
    <div v-show="title === tabs.labels[tabs.active]">
        <slot />
    </div>
</template>

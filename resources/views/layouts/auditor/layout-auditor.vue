<script lang="ts" setup>
import Header from "./partials/header.vue";
import Navigation from "./partials/navigation.vue";

defineProps<{
    user: Object | null;
}>();
</script>

<template>
    <div class="relative mb-16 bg-black text-base-100">
        <Header />
        <slot />
        <Navigation :user="user" />
    </div>
</template>

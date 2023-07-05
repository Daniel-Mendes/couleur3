<script lang="ts" setup>
import Header from "./partials/header.vue";
import Navigation from "./partials/navigation.vue";

defineProps<{
    auth: App.Data.UserData | null;
}>();
</script>

<template>
    <div class="relative mb-16 bg-black text-base-100">
        <Header />
        <slot />
        <Navigation :auth="auth" />
    </div>
</template>

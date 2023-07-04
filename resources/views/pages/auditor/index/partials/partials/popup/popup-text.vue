<script lang="ts" setup>
import TextInput from "@/views/components/Auditor/Bases/TextInput/TextInput.vue";
import { defineModel } from "vue";

const modelValue = defineModel();
</script>

<template>
    <div class="mb-10">
        <TextInput
            id="text-answer"
            v-model="modelValue" />
    </div>
</template>

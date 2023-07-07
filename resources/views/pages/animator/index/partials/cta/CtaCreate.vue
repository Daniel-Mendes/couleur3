<script lang="ts" setup>
import InputGroup from "@/views/components/InputGroup.vue";
import TextInput from "@/views/components/TextInput.vue";
import InputError from "@/views/components/InputError.vue";
import BaseCard from "@/views/components/animator/basics/BaseCard.vue";
import BaseButton from "@/views/components/animator/basics/BaseButton.vue";
import BaseDurationRange from "@/views/components/animator/basics/BaseDurationRange.vue";
import Color from "@/scripts/enums/Color.js";
import { useForm } from "laravel-precognition-vue-inertia";
import { useInteractionStore } from "@/scripts/stores/useInteractionStore.js";

const interactionStore = useInteractionStore();

const form = useForm("post", route("interactions.cta.store"), {
    title: "",
    link: "",
    duration: 300,
});

const submit = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            interactionStore.createdInteraction();
        },
    });
};
</script>

<template>
    <form @submit.prevent="submit">
        <BaseCard :color="Color.SECONDARY">
            <template #title>Lien</template>
            <template #content>
                <div class="flex flex-col gap-8">
                    <InputGroup
                        id="title"
                        label="Titre">
                        <TextInput
                            id="title"
                            v-model="form.title"
                            :color="Color.SECONDARY"
                            @change="form.validate('title')" />

                        <InputError
                            class="mt-2"
                            :message="form.errors.title" />
                    </InputGroup>

                    <InputGroup
                        id="link"
                        label="Lien">
                        <TextInput
                            id="link"
                            v-model="form.link"
                            placeholder="https://"
                            :color="Color.SECONDARY"
                            @change="form.validate('link')" />

                        <InputError
                            class="mt-2"
                            :message="form.errors.link" />
                    </InputGroup>

                    <InputGroup
                        id="duration"
                        label="Durée d'interaction">
                        <BaseDurationRange
                            id="duration"
                            v-model="form.duration"
                            class="items-center"
                            :min="15"
                            :color="Color.SECONDARY" />
                    </InputGroup>
                </div>
            </template>
            <template #actions>
                <div class="flex flex-row gap-3">
                    <BaseButton
                        :disabled="form.processing"
                        @click="interactionStore.cancelInteraction()"
                        >Annuler</BaseButton
                    >
                    <BaseButton
                        :disabled="form.processing"
                        :color="Color.SECONDARY"
                        type="submit"
                        >Envoyer</BaseButton
                    >
                </div>
            </template>
        </BaseCard>
    </form>
</template>

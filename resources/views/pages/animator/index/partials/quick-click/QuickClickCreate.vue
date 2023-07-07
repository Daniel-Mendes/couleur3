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

const form = useForm("post", route("interactions.quick_click.store"), {
    title: "Sois le premier à cliquer !",
    duration: 60,
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
        <BaseCard :color="Color.ACCENT">
            <template #title>Rapidité</template>
            <template #subtitle>
                Le but est de tester la rapidité des auditeurs. Sélectionnez automatiquement les premiers participants
                qui ont cliqué sur un bouton affiché à leur écran, afin de les récompenser.
            </template>
            <template #content>
                <div class="flex flex-col gap-8">
                    <InputGroup
                        id="title"
                        label="Titre">
                        <TextInput
                            id="title"
                            v-model="form.title"
                            :color="Color.ACCENT"
                            @change="form.validate('title')" />

                        <InputError
                            class="mt-2"
                            :message="form.errors.title" />
                    </InputGroup>

                    <InputGroup
                        id="duration"
                        label="Durée d'interaction">
                        <BaseDurationRange
                            id="duration"
                            v-model="form.duration"
                            :min="15"
                            :color="Color.ACCENT" />
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
                        :color="Color.ACCENT"
                        :disabled="form.processing"
                        type="submit"
                        >Envoyer</BaseButton
                    >
                </div>
            </template>
        </BaseCard>
    </form>
</template>

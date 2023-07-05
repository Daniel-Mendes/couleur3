<script setup>
import { computed } from "vue";
import AuditorLayout from "@/Layouts/AuditorLayout.vue";
import PrimaryButton from "@/Components/Auditor/Bases/PrimaryButton.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
    status: {
        type: String,
        default: "",
    },
});

const form = useForm({});

const submit = () => {
    form.post(route("verification.send"));
};

const verificationLinkSent = computed(() => props.status === "verification-link-sent");
</script>

<template>
    <AuditorLayout>
        <Head title="Email Verification" />
        <div class="flex h-screen flex-col items-center justify-center px-4">
            <div class="mb-4 text-base font-light text-base-100">
                Merci pour l'enregistrement! Avant de commencer, pourriez-vous vérifier votre adresse e-mail en cliquant
                sur le lien que nous venons de vous envoyer ? Si vous n'avez pas reçu l'e-mail, nous vous en enverrons
                un autre avec plaisir.
            </div>

            <div
                v-if="verificationLinkSent"
                class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
                Un nouveau lien de vérification a été envoyé à l'adresse e-mail que vous avez fournie lors de
                l'inscription.
            </div>

            <form @submit.prevent="submit">
                <div class="mt-4 flex items-center justify-between">
                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing">
                        Renvoyer l'e-mail de vérification
                    </PrimaryButton>

                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-base-100 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                        >Log Out</Link
                    >
                </div>
            </form>
        </div>
    </AuditorLayout>
</template>

<script lang="ts" setup>
import InputError from "@/views/components/InputError.vue";
import InputLabel from "@/views/components/InputLabel.vue";
import ButtonPrimary from "@/views/components/Auditor/Bases/Button/ButtonPrimary.vue";
import TextInput from "@/views/components/Auditor/Bases/TextInput/TextInput.vue";
import { useForm } from "laravel-precognition-vue-inertia";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm("put", route("password.update"), {
    current_password: "",
    password: "",
    password_confirmation: "",
});

const updatePassword = () => {
    form.put(route("password.update"), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset("password", "password_confirmation");
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset("current_password");
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-base-100">Mettre à jour le mot de passe</h2>

            <p class="mt-1 text-base font-light text-base-100">
                Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester en sécurité.
            </p>
        </header>

        <form
            class="mt-6 space-y-6"
            @submit.prevent="updatePassword">
            <div>
                <InputLabel
                    for="current_password"
                    value="Current Password" />

                <TextInput
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    label="Mot de passe actuel"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="current-password" />

                <InputError
                    :message="form.errors.current_password"
                    class="mt-2" />
            </div>

            <div>
                <InputLabel
                    for="password"
                    value="New Password" />

                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    label="Nouveau mot de passe"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password" />

                <InputError
                    :message="form.errors.password"
                    class="mt-2" />
            </div>

            <div>
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password" />

                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    label="Confirmer le mot de passe"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password" />

                <InputError
                    :message="form.errors.password_confirmation"
                    class="mt-2" />
            </div>

            <div class="flex items-center gap-4 text-lg font-light">
                <ButtonPrimary :disabled="form.processing">sauvegarder</ButtonPrimary>

                <Transition
                    enter-from-class="opacity-0"
                    leave-to-class="opacity-0"
                    class="transition ease-in-out">
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-base-100">
                        sauvegardé
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>

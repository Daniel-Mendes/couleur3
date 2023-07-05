<script lang="ts" setup>
import InputError from "@/views/components/InputError.vue";
import InputLabel from "@/views/components/InputLabel.vue";
import ButtonPrimary from "@/views/components/Auditor/Bases/Button/ButtonPrimary.vue";
import TextInput from "@/views/components/Auditor/Bases/TextInput/TextInput.vue";
import TextInputPostalCode from "@/views/components/Auditor/Bases/TextInput/TextInputPostalCode.vue";
import TextInputCity from "@/views/components/Auditor/Bases/TextInput/TextInputCity.vue";

const props = withDefaults(
    defineProps<{
        mustVerifyEmail: boolean;
        status: string;
        auth: App.Data.UserData | null;
        address: App.Data.AddressData | null;
    }>(),
    {
        status: "",
    }
);

const form = useForm({
    name: props.auth.name,
    email: props.auth.email,
    address: props.address,
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-base-100">Informations sur le profil</h2>

            <p class="mt-1 text-base font-light text-base-100">
                Mettez à jour les informations de profil et l'adresse e-mail de votre compte.
            </p>
        </header>

        <form
            class="mt-6 space-y-6"
            @submit.prevent="form.patch(route('profile.update'))">
            <div>
                <InputLabel
                    for="name"
                    value="Name" />

                <TextInput
                    id="name"
                    v-model="form.name"
                    label="Nom/Prénom"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="name" />

                <InputError
                    class="mt-2"
                    :message="form.errors.name" />
            </div>

            <div>
                <InputLabel
                    for="email"
                    value="Email" />

                <TextInput
                    id="email"
                    v-model="form.email"
                    label="Adresse mail"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autocomplete="username" />

                <InputError
                    class="mt-2"
                    :message="form.errors.email" />
            </div>

            <div>
                <InputLabel
                    for="street"
                    :value="address.street" />

                <TextInput
                    id="address"
                    v-model="form.address.street"
                    label="Adresse"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="address" />
            </div>

            <div class="mt-4 flex w-full gap-x-2">
                <div class="w-24">
                    <TextInputPostalCode
                        id="zip_code"
                        v-model="form.address.zip_code"
                        label="NPA"
                        type="zip_code"
                        autocomplete="zip_code" />
                </div>

                <div class="grow">
                    <TextInputCity
                        id="city"
                        v-model="form.address.city"
                        label="Ville"
                        type="city"
                        autocomplete="city" />
                </div>
            </div>

            <div>
                <InputLabel
                    for="street"
                    :value="address.country" />

                <TextInput
                    id="country"
                    v-model="form.address.country"
                    label="Pays"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="country" />
            </div>

            <InputError
                class="mt-2"
                :message="form.errors.address" />

            <div v-if="mustVerifyEmail && auth.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800 dark:text-gray-200">
                    Votre adresse e-mail n'est pas vérifiée.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800">
                        Cliquez ici pour renvoyer l'e-mail de vérification.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-green-600 dark:text-green-400">
                    Un nouveau lien de vérification a été envoyé à votre adresse e-mail.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <ButtonPrimary :disabled="form.processing">Sauvegarder</ButtonPrimary>

                <Transition
                    enter-from-class="opacity-0"
                    leave-to-class="opacity-0"
                    class="transition ease-in-out">
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-base-100">
                        Sauvegarder
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>

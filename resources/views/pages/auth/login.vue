<!-- eslint-disable no-undef -->
<script lang="ts" setup>
import Checkbox from "@/views/components/Auditor/Bases/Checkbox.vue";
import LayoutAuditor from "@/views/layouts/auditor/layout-auditor.vue";
import InputError from "@/views/components/InputError.vue";
import ProfileButton from "@/views/components/Auditor/Bases/Button/ButtonProfile.vue";
import TextInput from "@/views/components/Auditor/Bases/TextInput/TextInput.vue";
import { Head, Link } from "@inertiajs/vue3";
import { useForm } from "laravel-precognition-vue-inertia";

defineProps<{
    canResetPassword: {
        type: Boolean;
    };
    status: {
        type: String;
        default: "";
    };
    user: {
        type: Object;
        required: true;
    };
}>();

const form = useForm("post", route("login"), {
    email: "",
    password: "",
    remember: false,
});

const submit = () =>
    form.submit({
        preserveScroll: true,
        onSuccess: () => form.reset("password"),
    });
</script>

<template>
    <LayoutAuditor :user="user">
        <Head title="Login" />

        <div
            id="login"
            class="flex h-screen flex-col items-center justify-center px-3.5">
            <h2 class="mb-5 text-3xl font-semibold">Login</h2>
            <div
                v-if="status"
                class="mb-4 text-sm font-medium text-green-600">
                {{ status }}
            </div>

            <form
                class="flex w-full flex-col items-center"
                @submit.prevent="submit">
                <div class="w-full">
                    <TextInput
                        id="email"
                        v-model="form.email"
                        label="Adresse mail"
                        type="email"
                        class="mt-1 block w-full"
                        required
                        autofocus
                        autocomplete="username"
                        @change="form.validate('email')" />
                    <InputError
                        class="mt-2"
                        :message="form.errors.email" />
                </div>
                <div class="mt-4 w-full">
                    <TextInput
                        id="password"
                        v-model="form.password"
                        label="Mot de passe"
                        type="password"
                        class="mt-1 block w-full"
                        required
                        autocomplete="current-password"
                        @change="form.validate('password')" />
                    <InputError
                        class="mt-2"
                        :message="form.errors.password" />
                </div>

                <div class="mt-4 block">
                    <label class="flex items-center">
                        <Checkbox
                            v-model:checked="form.remember"
                            name="remember" />
                        <span class="ml-2 text-base text-base-100 dark:text-base-100">Se rappeler de moi</span>
                    </label>
                </div>
                <div class="mt-8 flex flex-col items-center gap-y-4">
                    <ProfileButton
                        :class="{ 'opacity-25': form.processing }"
                        :outlined="true"
                        :disabled="form.processing">
                        Se connecter
                    </ProfileButton>
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="text-sm text-base-100 underline hover:text-base-100 dark:text-base-100 dark:hover:text-base-100">
                        Mot de passe oublié ?
                    </Link>
                </div>
            </form>
            <ProfileButton
                :class="{ 'opacity-25': form.processing }"
                :outlined="false"
                :disabled="form.processing">
                <a :href="route('register')"> S'enregistrer</a>
            </ProfileButton>
        </div>
    </LayoutAuditor>
</template>

<script lang="ts" setup>
import ButtonDanger from "@/views/components/Auditor/Bases/Button/ButtonDanger.vue";
import InputError from "@/views/components/InputError.vue";
import InputLabel from "@/views/components/InputLabel.vue";
import Modal from "@/views/components/Modal.vue";
import ButtonSecondary from "@/views/components/Auditor/Bases/Button/ButtonSecondary.vue";
import TextInput from "@/views/components/Auditor/Bases/TextInput/TextInput.vue";

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: "",
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route("profile.destroy"), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-base-100">Supprimer le compte</h2>

            <p class="mt-1 text-base font-light text-base-100">
                Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Avant
                de supprimer votre compte, veuillez télécharger les données ou informations que vous souhaitez
                conserver.
            </p>
        </header>

        <ButtonDanger @click="confirmUserDeletion">Supprimer le compte</ButtonDanger>

        <Modal
            :show="confirmingUserDeletion"
            @close="closeModal">
            <div class="bg-black p-6">
                <h2 class="text-lg font-medium text-base-100">Êtes-vous sûr de vouloir supprimer votre compte ?</h2>

                <p class="mt-1 text-base text-base-100">
                    Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées.
                    Veuillez saisir votre mot de passe pour confirmer que vous souhaitez supprimer définitivement votre
                    compte.
                </p>

                <div class="mt-6">
                    <InputLabel
                        for="password"
                        value="Password"
                        class="sr-only" />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="Password"
                        @keyup.enter="deleteUser" />

                    <InputError
                        :message="form.errors.password"
                        class="mt-2" />
                </div>

                <div class="flex justify-end">
                    <ButtonSecondary @click="closeModal"> Annuler </ButtonSecondary>

                    <ButtonDanger
                        class="ml-3 mt-16 h-9"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser">
                        Supprimer le compte
                    </ButtonDanger>
                </div>
            </div>
        </Modal>
    </section>
</template>

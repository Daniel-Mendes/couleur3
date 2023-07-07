<script setup>
import { ref, reactive, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import MessageItem from "@/Components/MessageItem.vue";
import BaseButton from "@/Components/animator/basics/BaseButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    chatEnabled: {
        type: Boolean,
        required: true,
    },
});

const messageContainer = ref(null);

const data = reactive({
    chatEnabled: props.chatEnabled,
    messages: [],
});

onMounted(() => {
    subscribeToPublicChannel();
});

function subscribeToPublicChannel() {
    window.Echo.channel("public")
        .listen("MessageSent", (event) => {
            data.messages.push(event.message);
        })
        .listen("ChatUpdated", (event) => {
            data.chatEnabled = event.chatEnabled;

            if (!data.chatEnabled) {
                data.messages = [];
            }
        })
        .error((error) => {
            console.error(error);
        });
}

const form = reactive({
    message: "",
    errors: {},
});

const submitMessage = () => {
    form.processing = true;
    router.post(
        "/messages",
        {
            content: form.message,
        },
        {
            preserveState: true,
            preserveScroll: true,
            only: ["chatEnabled"],
            onSuccess: () => {
                form.message = "";
                form.processing = false;
                form.errors = {};
            },
            onError: (errors) => {
                form.errors = errors.errors;
                form.processing = false;
            },
        }
    );
};
</script>

<template>
    <div>
        <div
            id="myTabContent"
            class="tab-content mb-3">
            <div class="tab-pane fade show active">
                <div
                    v-if="data.messages && data.chatEnabled"
                    ref="messageContainer"
                    class="messageContainer">
                    <MessageItem
                        v-for="msg in data.messages"
                        :key="msg.id"
                        :msg="msg" />
                </div>

                <form @submit.prevent="submitMessage">
                    <div>
                        <TextInput
                            id="message"
                            v-model="form.message"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autofocus
                            placeholder="Message..."
                            :disabled="form.processing || !data.chatEnabled"
                            @keyup.enter="submitMessage" />

                        <InputError
                            class="mt-2"
                            :message="form.errors.message" />
                    </div>

                    <div class="row mb-2 mt-3">
                        <div class="col-6 text-start">
                            <PrimaryButton
                                :class="{
                                    'opacity-25':
                                        form.processing ||
                                        !form.message ||
                                        form.message.length < 1 ||
                                        !data.chatEnabled,
                                }"
                                :disabled="
                                    form.processing || !form.message || form.message.length < 1 || !data.chatEnabled
                                ">
                                Send message
                            </PrimaryButton>

                            <BaseButton>Bouton de basse</BaseButton>

                            <BaseButton color="primary"> Je test le bleu </BaseButton>

                            <BaseButton color="accent"> Je test le rose </BaseButton>

                            <BaseButton color="secondary"> Je test le jaune </BaseButton>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

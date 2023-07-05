<script lang="ts" setup>
import formatDateToHoursMinutes from "@/scripts/utils/date";
import { useChatStore } from "@/scripts/stores/useChatStore.js";
import { storeToRefs } from "pinia";

const chatStore = useChatStore();
const { isChatEnabled, messages } = storeToRefs(chatStore);

const messageContainer = ref(null);

const form = reactive({
    content: "",
    errors: {},
});

const submitMessage = () => {
    form.processing = true;
    router.post(route("messages.store"), form, {
        preserveScroll: true,
        onSuccess: () => {
            form.processing = false;
            form.errors = {};
            form.content = "";
        },
    });
};
// regarde si le tchat est ouvert ou non
function check($event) {
    if ($event.target.checked) {
        const heightHeaderPlayer = document.querySelector("#the-header").getBoundingClientRect().height + "px";
        document.querySelectorAll("body, #the-header").forEach((element) => {
            element.classList.add("chat-open");
        });
        document.querySelector("#fixed-container").classList.add("bg-black");
        document.querySelector("#description-live").style.marginTop = heightHeaderPlayer;
        document.querySelector("#fixed-container").style.top = heightHeaderPlayer;
        document.querySelector("#chat-auditor").style.gridTemplateRows = "auto 1fr";
    } else {
        document.querySelectorAll("body, #the-header").forEach((element) => {
            element.classList.remove("chat-open");
        });
        document.querySelector("#fixed-container").classList.remove("bg-black");
        document.querySelector("#description-live").style.marginTop = "";
        document.querySelector("#fixed-container").style.top = "";
        document.querySelector("#chat-auditor").style.gridTemplateRows = "";
    }
}
</script>

<template>
    <!-- Menu dépliant -->
    <div
        id="chat-auditor"
        class="bg-blue-auditor collapse rounded-b-none rounded-t-[44px]">
        <!-- Bouton pour déplier le menu-->
        <input
            type="checkbox"
            class="h-11 min-h-0 w-full"
            @change="check($event)" />
        <div class="collapse-title flex h-11 min-h-0 items-center justify-center p-0 text-base font-extrabold">
            Chat {{ isChatEnabled ? "" : "(désactivé par l'animateur)"
            }}<span class="material-symbols-rounded ml-1 align-middle transition-transform"> expand_less </span>
        </div>
        <!-- Contenu du menu dépliant -->
        <div class="collapse-content flex flex-col gap-y-3.5 px-3.5">
            <!-- Messages dans le chat -->
            <div class="flex h-2 grow flex-col-reverse overflow-y-scroll">
                <!-- Ajouter les nouveaux message ici-->
                <div
                    v-if="messages && isChatEnabled"
                    ref="messageContainer">
                    <p
                        v-for="msg in messages"
                        :key="msg.id"
                        class="font-light">
                        <span class="text-base-100 opacity-70"> {{ formatDateToHoursMinutes(msg.created_at) }} </span
                        ><span class="ml-2 font-bold">{{ msg.user_name }} : </span><span>{{ msg.content }}</span>
                    </p>
                </div>
            </div>
            <!-- Formulaire pour envoyer des messages dans le chat -->
            <div class="flex flex-col gap-y-1">
                <form @submit.prevent="submitMessage">
                    <div class="flex gap-x-5">
                        <input
                            id="message"
                            v-model="form.content"
                            type="text"
                            class="bg-blue-auditor grow rounded-full border-base-100 placeholder:font-extralight focus:border-base-100 focus:outline-0"
                            required
                            autofocus
                            placeholder="Message…"
                            :disabled="form.processing || !isChatEnabled"
                            @keyup.enter="submitMessage" />
                        <button
                            class="flex w-16 items-center justify-center rounded-full border border-base-100 bg-base-100"
                            type="submit">
                            <span class="material-symbols-rounded text-blue-auditor align-middle"> send </span>
                        </button>
                    </div>
                    <div v-show="form.errors.message">
                        <p class="text-sm text-red-600 dark:text-red-400">
                            {{ form.errors.message }}
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>
input[type="checkbox"]:checked ~ div:first-of-type > span {
    transform: rotate(180deg);
}
input[type="checkbox"]:checked ~ div:last-of-type {
    padding-bottom: 0.875rem;
}
input[type="text"]::placeholder {
    color: #ffffffbf;
}
input[type="text"]:placeholder-shown + button {
    background-color: transparent;
}
input[type="text"]:placeholder-shown + button span {
    color: #ffffff;
}
input[type="text"]:disabled,
input[type="text"]:disabled + button {
    cursor: not-allowed;
    opacity: 0.5;
}
</style>

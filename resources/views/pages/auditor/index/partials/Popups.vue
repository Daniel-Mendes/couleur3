<script lang="ts" setup>
import { ref, computed, watch } from "vue";
// Construction du popup
import BaseButtonPopup from "@/views/components/Auditor/Bases/Popup/BaseButtonPopup.vue";
import BasesTitrePopup from "@/views/components/Auditor/Bases/Popup/BasesTitrePopup.vue";
import PopupTitleType from "@/scripts/enums/PopupTitleType.js";
// type de popup
import PopupText from "./partials/popup/popup-text.vue";
import PopupSurveyMcq from "./partials/popup/popup-survey-mcq.vue";
// Interaction activée
import InteractionType from "@/scripts/enums/InteractionType.js";
import { useInteractionStore } from "@/scripts/stores/useInteractionStore.js";
import { storeToRefs } from "pinia";
import { router } from "@inertiajs/vue3";

// permet de récupérer la personne authentifiée si elle existe
const props = defineProps<{
    auth: Object | null;
}>();
const interactionStore = useInteractionStore();
const { currentInteraction, hasOpenedNotif, hasBeenRewarded, hasAnswerd } = storeToRefs(interactionStore);

const submitQuickClickAnswer = () => {
    router.post(route("interactions.answers.quick_click.store", currentInteraction.value.id));
};

const submitTextAnswer = () => {
    router.post(route("interactions.answers.text.store", currentInteraction.value.id), {
        content: inputTextValue.value,
    });
};

watch(hasOpenedNotif, () => {
    if (
        props.auth &&
        hasOpenedNotif.value !== false &&
        currentInteraction.value?.type === InteractionType.QUICK_CLICK
    ) {
        submitQuickClickAnswer();
    }
});

const inputTextValue = ref("");

const formValidation = computed(() => {
    if (currentInteraction.value?.type === InteractionType.TEXT) {
        return inputTextValue.value.length > 0;
    }

    return false;
});

// Constante pour afficher ou non les titres et la validation
const popupTitle = computed(() => {
    if (hasBeenRewarded.value !== null) {
        document.querySelector("#popup-auditor").showModal();
        return PopupTitleType.GIFT;
    }
    if (InteractionType.isQuestion(currentInteraction.value?.type)) {
        return PopupTitleType.QUESTION;
    } else if (currentInteraction.value?.type === InteractionType.QUICK_CLICK) {
        if (props.auth === null) {
            return PopupTitleType.QUICK;
        }
    }
    if (!hasAnswerd.value) {
        return PopupTitleType.THANKS;
    }
    return null;
});

// Clique sur le bouton du popup
function handleButtonPopup($event) {
    if ($event.target.id === "login") {
        window.location.href = "/login";
    } else if ($event.target.id === "next") {
        window.location.href = "/profile";
    } else if ($event.target.id === "send") {
        if (currentInteraction.value.type === InteractionType.TEXT) {
            submitTextAnswer();
            inputTextValue.value = "";
            hasAnswerd.value = true;
            document.querySelector("#closePopup").click();
        }

        popupTitle.value = "thanks";
    } else if ($event.target.id === "closeGift" && hasBeenRewarded.value !== null) {
        hasBeenRewarded.value = null;
        hasAnswerd.value = true;
    }
}
</script>

<template>
    <dialog
        v-if="
            (currentInteraction !== null && popupTitle !== null) ||
            (currentInteraction !== null && currentInteraction.value.type === InteractionType.TEXT && !hasAnswerd)
        "
        id="popup-auditor"
        class="modal">
        <form
            method="dialog"
            class="gradient-auditor text-blue-auditor modal-box flex flex-col">
            <!-- Ferme le popup-->
            <button
                id="closePopup"
                for="my-modal-3"
                class="absolute right-4 top-4">
                <span class="material-symbols-rounded text-4xl leading-none"> cancel </span>
            </button>
            <!-- Contenu du popup -->
            <div class="flex flex-col">
                <!-- Titre du popup -->
                <BasesTitrePopup
                    v-if="popupTitle === PopupTitleType.QUESTION"
                    icon="help"
                    >L’animateur aimerait connaître ton avis !</BasesTitrePopup
                >
                <BasesTitrePopup
                    v-if="popupTitle === PopupTitleType.THANKS"
                    icon="sentiment_very_satisfied"
                    >L’animateur te remercie pour ta participation !</BasesTitrePopup
                >
                <BasesTitrePopup
                    v-if="popupTitle === PopupTitleType.GIFT"
                    icon="redeem"
                    >Vous avez gagné ce prix !<br />
                    {{ hasBeenRewarded.name }} : {{ hasBeenRewarded.description.toLowerCase() }}</BasesTitrePopup
                >
                <BasesTitrePopup
                    v-if="popupTitle === PopupTitleType.QUICK"
                    icon="bolt"
                    >{{ currentInteraction.title }}</BasesTitrePopup
                >
                <!-- Question du popup -->
                <p
                    v-if="currentInteraction.type !== InteractionType.QUICK_CLICK"
                    class="mb-8 text-base font-bold text-base-100">
                    {{ currentInteraction.title }}
                </p>
                <!-- Type du popup -->
                <PopupText
                    v-if="!hasAnswerd && currentInteraction.type === InteractionType.TEXT && auth !== null"
                    v-model="inputTextValue" />
                <PopupSurveyMcq
                    v-if="
                        (currentInteraction.type === InteractionType.SURVEY ||
                            currentInteraction.type === InteractionType.MCQ) &&
                        auth !== null
                    " />
                <!-- Bouton envoyer, fermer, suivant, se connecter -->
                <div class="flex justify-center">
                    <BaseButtonPopup
                        v-if="popupTitle === PopupTitleType.THANKS && auth !== null"
                        id="close"
                        :is-validate="true"
                        @click="handleButtonPopup"
                        >Fermer</BaseButtonPopup
                    >
                    <BaseButtonPopup
                        v-if="popupTitle === PopupTitleType.GIFT && auth !== null"
                        id="closeGift"
                        :is-validate="true"
                        @click="handleButtonPopup"
                        >Fermer</BaseButtonPopup
                    >
                    <BaseButtonPopup
                        v-if="popupTitle === PopupTitleType.GIFT && auth === null"
                        id="next"
                        :is-validate="true"
                        @click="handleButtonPopup"
                        >Suivant</BaseButtonPopup
                    >
                    <BaseButtonPopup
                        v-if="
                            currentInteraction.type !== InteractionType.MCQ &&
                            currentInteraction.type !== InteractionType.SURVEY &&
                            popupTitle === PopupTitleType.QUESTION &&
                            auth !== null
                        "
                        id="send"
                        :is-validate="formValidation"
                        @click="handleButtonPopup"
                        >Envoyer</BaseButtonPopup
                    >
                    <BaseButtonPopup
                        v-if="
                            (popupTitle === PopupTitleType.QUESTION || popupTitle === PopupTitleType.QUICK) &&
                            auth === null
                        "
                        id="login"
                        :is-validate="true"
                        @click="handleButtonPopup"
                        >Se connecter</BaseButtonPopup
                    >
                </div>
            </div>
        </form>
    </dialog>
</template>

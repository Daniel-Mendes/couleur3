<script lang="ts" setup>
import Recommandation from "./partials/Recommandation.vue";

defineProps<{
    type: {
        type: String;
        default: "white";
        required: false;
    };
}>();

onMounted(() => {
    const shareButton = document.getElementById("share");

    shareButton.addEventListener("click", () => {
        if (navigator.share) {
            navigator
                .share({
                    title: "Viens suivre l'émission ",
                    url: "/",
                })
                .catch(console.error);
        }
    });
});
</script>

<template>
    <div
        id="description-live"
        class="bg-black px-3.5 pb-20 pt-5 text-base-100">
        <p
            id="titre-emission"
            class="text-3xl font-semibold">
            La chose publique
        </p>

        <p
            id="heure-emission"
            class="mt-1 text-base font-bold">
            de 11h00 à 12h00
        </p>

        <p
            id="presentation-emission"
            class="mt-1 text-base font-light">
            Présenté par <span class="text-primary">Patrick Dujany</span>
        </p>

        <button
            id="share"
            :class="`btn btn-${type} btn-md mt-5 flex h-[40px] rounded-full border-none px-5 text-lg font-light text-base-100`"
            style="background-color: rgba(255, 255, 255, 0.25)">
            <span class="material-symbols-rounded font-light"> ios_share </span>
            Partager
        </button>
        <hr class="mt-8" />

        <Recommandation />
    </div>
</template>

<style scoped>
#share {
    font-variation-settings: "wght" 200;
}
</style>

<script lang="ts" setup>
const props = defineProps<{
    user: {
        type: Object;
        default: null;
    };
}>();

// Créer une référence aux boutons de navigation
const buttons = ref([
    { name: "home", active: false },
    { name: "search", active: false },
    { name: "smart_display", active: location.pathname === "/" },
    { name: "person", active: location.pathname !== "/" },
]);

// Fonction appelée lorsqu'on clique sur un bouton
function handleButtonClick(index) {
    if (buttons.value[index].name === "person" && props.user === null) {
        // Rediriger vers la page de login si l'utilisateur est pas connecté
        window.location.href = "/login";
    } else if (buttons.value[index].name === "person" && props.user !== null) {
        // Rediriger vers la page de profil si l'utilisateur est connecté
        window.location.href = "/profile";
    } else if (buttons.value[index].name === "smart_display") {
        // Rediriger vers la page du lecteur
        window.location.href = "/";
    } else {
        // Parcourir tous les boutons et les mettre à jour
        buttons.value.forEach((button, i) => {
            button.active = i === index;
        });
    }
}
</script>

<template>
    <div class="btm-nav fixed bottom-0 h-16 bg-black">
        <button
            v-for="(button, index) in buttons"
            :key="index"
            :class="['bg-black', { active: button.active }]"
            @click="handleButtonClick(index)">
            <span
                v-if="button.name !== 'person'"
                class="material-symbols-rounded text-3xl">
                {{ button.name }}
            </span>
            <span
                v-if="button.name === 'person' && user === null"
                class="material-symbols-rounded text-3xl">
                {{ button.name }}
            </span>
            <span
                v-if="button.name === 'person' && user !== null"
                class="flex h-9 w-9 items-center justify-center rounded-full bg-base-100 font-bold text-black">
                <span>{{ user.name[0] }}</span>
            </span>
        </button>
    </div>
</template>

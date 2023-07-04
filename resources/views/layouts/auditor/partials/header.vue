<script lang="ts" setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import PrimaryButton from "@/views/components/Auditor/Bases/Button/ButtonPrimary.vue";
import MiniaturePlayer from "./partials/MiniaturePlayer.vue";

const activePage = ref(location.pathname);
</script>

<template>
    <header
        v-if="activePage === '/'"
        id="the-header"
        class="flex h-16 justify-center bg-black px-3.5 py-4">
        <img
            class="h-full"
            src="@/images/Logo_Couleur_3.svg"
            alt="Logo de Couleur 3" />
    </header>
    <header
        v-if="activePage !== '/'"
        id="the-header"
        class="fixed z-10 w-full bg-black">
        <MiniaturePlayer class="h-16" />
        <div
            v-if="activePage === '/profile'"
            class="flex h-16 items-center px-3.5">
            <PrimaryButton>
                <Link
                    href="/logout"
                    method="post"
                    as="button"
                    class="flex items-center gap-x-1.5"
                    ><span class="material-symbols-rounded"> logout </span> <span>Se déconnecter</span></Link
                >
            </PrimaryButton>
        </div>
    </header>
</template>

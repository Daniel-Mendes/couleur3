import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import eslintPlugin from "vite-plugin-eslint";
import VueI18nPlugin from "@intlify/unplugin-vue-i18n/vite";
import { VitePWA } from "vite-plugin-pwa";
import { watch } from "vite-plugin-watch";
import autoimport from "unplugin-auto-import/vite";
import components from "unplugin-vue-components/vite";

export default defineConfig({
    resolve: {
        alias: {
            "@": "/resources",
            ziggy: "vendor/tightenco/ziggy/dist/vue.es.js",
            zora: "vendor/jetstreamlabs/zora/dist/vue.js",
            "zora-js": "vendor/jetstreamlabs/zora/dist/index.js",
        },
    },
    plugins: [
        laravel({
            input: "resources/scripts/app.ts",
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
            script: {
                defineModel: true,
            },
        }),
        eslintPlugin(),
        VueI18nPlugin(),
        VitePWA({
            outDir: "public/build",
            scope: "/",
            base: "/",
            registerType: "autoUpdate",
            manifest: {
                name: "Couleur 3 SparkShow",
                short_name: "Couleur3",
                description: "Intéragissez avec Couleur 3",
                start_url: "/",
                scope: "/",
                display: "standalone",
                icons: [
                    {
                        src: "../images/couleur3-high.png",
                        sizes: "247x247",
                        type: "image/png",
                    },
                    {
                        src: "../images/couleur3-low.png",
                        sizes: "72x72",
                        type: "image/png",
                    },
                ],
            },
        }),
        watch({
            pattern: "app/{Data,Enums}/**/*.php",
            command: "php artisan typescript:transform",
        }),
        watch({
            pattern: "routes/*.php",
            command: "php artisan trail:generate",
        }),
        watch({
            pattern: "lang/**/*.php",
            command: "php artisan zora:generate",
        }),
        autoimport({
            vueTemplate: true,
            dts: "resources/scripts/types/auto-imports.d.ts",
            imports: [
                "vue",
                { pinia: ["defineStore", "storeToRefs"] },
                { "momentum-lock": ["can"] },
                { "momentum-trail": ["route", "current"] },
                { "@inertiajs/vue3": ["router", "useForm", "usePage"] },
            ],
        }),
        components({
            dirs: ["resources/views/components", "resources/pages/**/partials"],
            dts: "resources/scripts/types/components.d.ts",
            resolvers: [
                (name: string) => {
                    const components = ["Link", "Head"];

                    if (components.includes(name)) {
                        return { name, from: "@inertiajs/vue3" };
                    }
                },
            ],
        }),
    ],
    server: {
        hmr: {
            host: "127.0.0.1",
        },
    },
});

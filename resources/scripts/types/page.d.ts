import "@inertiajs/vue3"
import { Page } from "@inertiajs/core"

declare module "@inertiajs/vue3" {
    export declare function usePage(): Page<App.Data.SharedData>
}

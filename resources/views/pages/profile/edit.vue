<script lang="ts" setup>
import LayoutAuditor from "@/views/layouts/auditor/layout-auditor.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";

withDefaults(
    defineProps<{
        mustVerifyEmail: boolean;
        status: string;
        auth: App.Data.UserData | null;
        address: App.Data.AddressData | null;
    }>(),
    {
        status: "",
    }
);
</script>

<template>
    <Head title="Profile" />

    <LayoutAuditor :auth="auth">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Profile</h2>
        </template>

        <div>
            <div class="mx-auto max-w-7xl space-y-6 pt-32 sm:px-6 lg:px-8">
                <div class="bg-black p-4 shadow sm:rounded-lg sm:p-8">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        :auth="auth"
                        :address="address"
                        class="max-w-xl" />
                </div>

                <div class="bg-black p-4 shadow sm:rounded-lg sm:p-8">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div class="bg-black p-4 pb-20 shadow sm:rounded-lg sm:p-8">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </LayoutAuditor>
</template>

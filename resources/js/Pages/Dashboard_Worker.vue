<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
//import index from './devices/Index.vue';
</script>

<template>
    <Head title="Dashboard Worker" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Dashboard Employé
            </h2>
        </template>
        <template #default>
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h1>Prochainement:<br> graphiques pour l'employé</h1>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <!-- <index /> -->
    </AuthenticatedLayout>
</template>

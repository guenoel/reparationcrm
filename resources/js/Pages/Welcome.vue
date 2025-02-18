<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Accueil - Gestion Boutique" />
    <div class="dark:text-white">
        <!-- Hero Section -->
        <div class="relative flex flex-col items-center justify-center min-h-screen text-white">
            <!-- Content Section with Background -->
            <div 
                class="absolute inset-0 bg-cover bg-center z-[-1]" 
                style="background-image: url('/upload/mobile-phone-repair-services-1708933306109.jpg');"
            >
                <!-- Overlay to dim the image -->
                <div class="absolute inset-0 bg-black/80"></div>
            </div>
            <div class="relative max-w-5xl text-center">
                <h1 class="text-4xl lg:text-6xl font-bold mb-6">
                    Gestion de Boutique de Réparation
                </h1>
                <p class="text-lg lg:text-xl mb-8">
                    Simplifiez la gestion de vos réparations pour téléphones, tablettes et ordinateurs.
                </p>
                <div class="flex justify-center gap-4">
                    <Link
                        v-if="canLogin"
                        :href="route('dashboard_admin')"
                        class="bg-white text-blue-600 font-medium rounded-md px-6 py-3 shadow-lg hover:bg-gray-100 transition"
                    >
                        Accéder à l'application
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="bg-blue-700 text-white font-medium rounded-md px-6 py-3 shadow-lg hover:bg-blue-800 transition"
                    >
                        Créer un compte
                    </Link>
                    <Link
                        v-else
                        :href="route('login')"
                        class="bg-blue-700 text-white font-medium rounded-md px-6 py-3 shadow-lg hover:bg-blue-800 transition"
                    >
                        Se connecter
                    </Link>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-20 bg-gray-50 dark:bg-gray-900">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12">
                    Pourquoi choisir notre solution ?
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="flex flex-col items-center text-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                        <img
                            src="https://img.icons8.com/external-justicon-lineal-color-justicon/64/000000/external-repair-essentials-justicon-lineal-color-justicon.png"
                            alt="Gestion Réparations"
                            class="mb-4"
                        />
                        <h3 class="text-xl font-bold mb-2">Suivi des Réparations</h3>
                        <p>
                            Suivez facilement l'état des réparations et assurez une communication fluide avec vos clients.
                        </p>
                    </div>
                    <!-- Feature 2 -->
                    <div class="flex flex-col items-center text-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                        <img
                            src="https://img.icons8.com/external-flatart-icons-outline-flatarticons/64/000000/external-dashboard-dashboard-flatart-icons-outline-flatarticons.png"
                            alt="Statistiques"
                            class="mb-4"
                        />
                        <h3 class="text-xl font-bold mb-2">Statistiques et Rapports</h3>
                        <p>
                            Obtenez des rapports détaillés sur les performances de votre boutique pour améliorer vos services.
                        </p>
                    </div>
                    <!-- Feature 3 -->
                    <div class="flex flex-col items-center text-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                        <img
                            src="https://img.icons8.com/external-flatart-icons-outline-flatarticons/64/000000/external-customer-support-flatart-icons-outline-flatarticons.png"
                            alt="Gestion Clients"
                            class="mb-4"
                        />
                        <h3 class="text-xl font-bold mb-2">Gestion des Clients</h3>
                        <p>
                            Gérez efficacement les informations de vos clients et améliorez leur expérience globale.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-blue-600 dark:bg-blue-900 text-white py-6">
            <div class="container mx-auto px-4 text-center">
                <p class="text-sm">
                    © 2025 <a href="https://guenoel.com">guenoel.com</a>. Tous droits réservés.
                </p>
            </div>
        </footer>
    </div>
</template>

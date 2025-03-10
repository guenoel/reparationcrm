<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, watch, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/vue3';
//import { useRoute, useRouter } from 'vue-router';

//const router = useRouter()

// defineProps({
//     services: {
//         type: Array,
//         required: true
//     }
// });
const page = usePage();
let services = ref([]);
let links = ref([]);
let searchQuery = ref('');
const hideUserDropdown = ref(false);
const activeFilters = ref([]); // Correct : tableau vide
const itemsPerPage = ref(10); // Valeur par défaut

onMounted(async () => {
    // Check user role and set dropdown visibility 
    const authUser = page.props.auth.user;
    if (authUser && authUser.role === 0) {
        hideUserDropdown.value = true;
    }
    
    getServices();
});

watch(searchQuery, () => {
    getServices();
});

//const newService = () => {
//    //router.push('/services/create')
//    Inertia.visit('/services/create')
//}

// Déterminer la classe de la ligne en fonction des conditions
const getRowClass = (service) => {
    if (!service.price_paid && !service.accepted && !service.done && service.returned) {
        return 'bg-gray-200'; // Gris clair
    }
    if (!service.price_paid && !service.accepted && !service.done && !service.returned) {
        return 'bg-orange-300'; // Orange
    }
    if (service.price_paid && !service.accepted && !service.done && !service.returned) {
        return 'bg-orange-500'; // Orange foncé
    }
    if (!service.price_paid && service.accepted && !service.done && !service.returned) {
        return 'bg-blue-300'; // bleu clair
    }
    if (service.price_paid && service.accepted && !service.done && !service.returned) {
        return 'bg-blue-500'; // bleu moyen
    }
    if (!service.price_paid && service.accepted && service.done && !service.returned) {
        return 'bg-green-300'; // Vert clair
    }
    if (service.price_paid && service.accepted && service.done && !service.returned) {
        return 'bg-green-700'; // Vert foncé
    }
    if (service.price_paid && service.accepted && service.done && service.returned) {
        return 'bg-gray-500'; // Gris foncé
    }
    if (!service.price_paid && service.accepted && service.done && service.returned) {
        return 'bg-red-500'; // Rouge
    }
    
    return ''; // Classe par défaut
};


// Filtrer les services en fonction des classes sélectionnées
const filteredServices = computed(() => {
    if (activeFilters.value.length === 0) {
        return services.value; // Aucun filtre actif, retourner tous les services
    }
    return services.value.filter((service) => activeFilters.value.includes(getRowClass(service)));
});

// Gérer la sélection/dé-sélection d'un filtre
const toggleFilter = (filterClass) => {
    if (activeFilters.value.includes(filterClass)) {
        // Si le filtre est déjà actif, on le retire
        activeFilters.value = activeFilters.value.filter((item) => item !== filterClass);
    } else {
        // Sinon, on l'ajoute
        activeFilters.value.push(filterClass);
    }
};


const getServices = async () => {
    try {
        const response = await axios.get(`/api/services?searchQuery=${searchQuery.value}&perPage=${itemsPerPage.value}`);
        services.value = response.data.services.data;
        links.value = response.data.services.links;
    } catch (error) {
        console.error("Error fetching services:", error);
    }
};

const redirectToTaskForm = (serviceId) => {
  // Redirect to the task form with the service_id as a query parameter
    Inertia.visit(`/tasks/create?service_id=${serviceId}`);
};

const redirectToSpareForm = (serviceId) => {
  // Redirect to the spare form with the service_id as a query parameter
    Inertia.visit(`/spares/create?service_id=${serviceId}`);
};

const changePage = (link) => {
    if (!link.url || link.active) {
        return;
    }

    axios.get(link.url)
        .then((response) => {
            services.value = response.data.services.data;
            links.value = response.data.services.links;
        });
};

const onEdit = (id) => {
    //router.push(`/services/${id}/edit`)
    Inertia.visit(`/services/${id}/edit`);
};

const deleteService = (id) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/api/services/${id}`)
                .then(() => {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });
                    getServices();
                });
        }
    });
};

const redirectToTicket = (serviceId) => {
    window.open(`/services/${serviceId}/ticket`, '_blank');
};
</script>

<template>
    <Head title="Enregistrement prestation" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                <span>Prestations</span>
            </h2>
        </template>
        <template #default>
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="devices__list table">
                    <div class="customers__titlebar dflex justify-content-between align-items-center">
                        <div class="customers__titlebar--item">
                            <h1>Prestations</h1>
                        </div>
                        <!-- <div class="customers__titlebar--item">
                            <Link href="/services/create" class="btn btn-secondary my-1">
                            Ajouter une prestation
                            </Link>
                        </div> -->
                    </div>
                    <div class="relative">
                        <input class="search-input" type="text" name="search" placeholder="Recherche prestation..."
                            v-model="searchQuery" />
                    </div>
                    <div class="legend--title">
                        <p>Légende et filtre:</p>
                    </div>
                    <div class="legend--services">
                        <span
                            class="bg-orange-300"
                            :class="{ 'active-filter': activeFilters.includes('bg-orange-300') }"
                            @click="toggleFilter('bg-orange-300')"
                        >
                            Non payé, non accepté, non terminé, non rendu
                        </span>
                        <span
                            class="bg-orange-500"
                            :class="{ 'active-filter': activeFilters.includes('bg-orange-500') }"
                            @click="toggleFilter('bg-orange-500')"
                        >
                            Payé, non accepté, non terminé, non rendu
                        </span>
                        <span
                            class="bg-red-500"
                            :class="{ 'active-filter': activeFilters.includes('bg-red-500') }"
                            @click="toggleFilter('bg-red-500')"
                        >
                            Non payé, accepté, terminé, rendu
                        </span>
                        
                        <span
                            class="bg-blue-300"
                            :class="{ 'active-filter': activeFilters.includes('bg-blue-300') }"
                            @click="toggleFilter('bg-blue-300')"
                        >
                            Non Payé, accepté, non terminé, non rendu
                        </span>
                        <span
                            class="bg-blue-500"
                            :class="{ 'active-filter': activeFilters.includes('bg-blue-500') }"
                            @click="toggleFilter('bg-blue-500')"
                        >
                            Payé, accepté, non terminé, non rendu
                        </span>
                        <span
                            class="bg-gray-200"
                            :class="{ 'active-filter': activeFilters.includes('bg-gray-200') }"
                            @click="toggleFilter('bg-gray-200')"
                        >
                            Non payé, non accepté, non terminé, rendu
                        </span>
                        <span
                            class="bg-green-300"
                            :class="{ 'active-filter': activeFilters.includes('bg-green-300') }"
                            @click="toggleFilter('bg-green-300')"
                        >
                            Non payé, accepté, terminé, non rendu
                        </span>
                        <span
                            class="bg-green-700"
                            :class="{ 'active-filter': activeFilters.includes('bg-green-700') }"
                            @click="toggleFilter('bg-green-700')"
                        >
                            Payé, accepté, terminé, non rendu
                        </span>
                        <span
                            class="bg-gray-500"
                            :class="{ 'active-filter': activeFilters.includes('bg-gray-500') }"
                            @click="toggleFilter('bg-gray-500')"
                        >
                            Payé, accepté, terminé, rendu
                        </span>
                    </div>
                    <div class="table--heading mt-2 services__list__heading " style="padding-top: 20px;background:#FFF">
                        <p class="table--heading--col1">Utilisateur</p>
                        <p class="table--heading--col2">Marque</p>
                        <p class="table--heading--col3">Nom Modèle</p>
                        <p class="table--heading--col4">No Modèle</p>
                        <p class="table--heading--col5">No Serie</p>
                        <p class="table--heading--col6">Description de la prestation</p>
                        <p class="table--heading--col7">Prix</p>
                        <p class="table--heading--col8">Actions</p>
                    </div>

                    <!-- device 1 -->
                    <div class="table--items services__list__item" v-for="service in filteredServices" :key="service.id" :class="getRowClass(service)">
                        <p>{{ service.device.user.name }}</p>
                        <p>{{ service.device.brand }}</p>
                        <p>{{ service.device.model_name }}</p>
                        <p>{{ service.device.model_number }}</p>
                        <p>{{ service.device.serial_number }}</p>
                        <p>{{ service.description }}</p>
                        <p>{{ service.price }}</p>
                        <div>
                            <button class="btn-icon btn-icon-success" @click="onEdit(service.id)">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button v-if="!hideUserDropdown || !service.price" class="btn-icon btn-icon-danger" @click="deleteService(service.id)">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                        <div v-if="!hideUserDropdown">
                            <Link href="/tasks/create" class="btn btn-secondary my-1" @click="redirectToTaskForm(service.id)">
                            Ajouter une tâche
                            </Link>
                        </div>
                        <div v-if="!hideUserDropdown">
                            <Link href="/spares/create" class="btn btn-secondary my-1" @click="redirectToSpareForm(service.id)">
                            Ajouter une pièce
                            </Link>
                        </div>
                        <div v-if="!hideUserDropdown">
                            <Link href="#" class="btn btn-secondary my-1" @click.prevent="redirectToTicket(service.id)">
                            Ticket
                            </Link>
                        </div>
                    </div>
                    <div class="table--items devices__list__bottom">
                        <ul class="pagination">
                            <a href="#" class="btn btn-secondary" v-for="(link, index) in links" :key="index" v-html="link.label"
                                :class="{ active: link.active, disable: !link.url }" @click="changePage(link)"></a>
                        </ul>
                        <select
                            v-model="itemsPerPage"
                            @change="getServices"
                            class="select-pagination"
                        >
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="500">500</option>
                            <option value="1000">1000</option>
                        </select>
                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

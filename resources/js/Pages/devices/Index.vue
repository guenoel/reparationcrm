<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, watch, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';
//import { useRoute, useRouter } from 'vue-router';

//const router = useRouter()

// defineProps({
//     devices: {
//         type: Array,
//         required: true
//     }
// });

let devices = ref([]);
let links = ref([]);
let searchQuery = ref('');
const activeFilters = ref([]); // Correct : tableau vide
const itemsPerPage = ref(10); // Valeur par défaut

onMounted(async () => {
    getDevices();
});

watch(searchQuery, () => {
    getDevices();
});

//const newDevice = () => {
//    //router.push('/devices/create')
//    Inertia.visit('/devices/create')
//}

const getRowClass = (device) => {
    if (!device.returned) {
        return 'bg-green-300'; // Vert clair
    }
    return 'bg-gray-200'; // Classe par défaut
};

// Filtrer les services en fonction des classes sélectionnées
const filteredDevices = computed(() => {
    if (activeFilters.value.length === 0) {
        return devices.value; // Aucun filtre actif, retourner tous les services
    }
    return devices.value.filter((service) => activeFilters.value.includes(getRowClass(service)));
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

const ourDeviceImage = (img) => {
    return "/upload/" + img;
};

const getDevices = async () => {
    try {
        const response = await axios.get(`/api/devices?searchQuery=${searchQuery.value}&perPage=${itemsPerPage.value}`);
        devices.value = response.data.devices.data || [];
        links.value = response.data.devices.links || [];
    } catch (error) {
        console.error("Error fetching devices:", error);
    }
};

const redirectToServiceForm = (deviceId) => {
  // Redirect to the services form with the device_id as a query parameter
    Inertia.visit(`/services/create?device_id=${deviceId}`);
};

const changePage = (link) => {
    if (!link.url || link.active) {
        return;
    }

    axios.get(link.url)
        .then((response) => {
            devices.value = response.data.devices.data;
            links.value = response.data.devices.links;
        });
};

const onEdit = (id) => {
    //router.push(`/devices/${id}/edit`)
    Inertia.visit(`/devices/${id}/edit`);
};

const deleteDevice = (id) => {
    Swal.fire({
        title: "Etes vous sur ?",
        text: "Vous ne pourrez pas annuler cette action !",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "oui, supprimer!"
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/api/devices/${id}`)
                .then(() => {
                    Swal.fire({
                        title: "Supprimé!",
                        text: "Appareil supprimé avec succès.",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                    getDevices();
                });
        }
    });
};

</script>

<template>
    <Head title="Enregistrement Appareil" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                <span>Appareils</span>
            </h2>
        </template>
        <template #default>
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="devices__list table">
                    <div class="customers__titlebar dflex justify-content-between align-items-center">
                        <div class="customers__titlebar--item">
                            <h1>Appareils</h1>
                        </div>
                        <div class="customers__titlebar--item">
                            <Link href="/devices/create" class="btn btn-secondary my-1">
                            Ajouter un appareil
                            </Link>
                        </div>
                    </div>
                    <div class="relative">
                        <input class="search-input" type="text" name="search" placeholder="Recherche d'appareil..."
                            v-model="searchQuery" />
                    </div>
                    <div class="legend--title">
                        <p>Légende:</p>
                    </div>
                    <div class="legend--devices">
                        <span class="bg-gray-200" :class="{ 'active-filter': activeFilters.includes('bg-gray-200') }"
                        @click="toggleFilter('bg-gray-200')">Appareil rendu</span>
                        <span class="bg-green-300"  :class="{ 'active-filter': activeFilters.includes('bg-green-300') }"
                        @click="toggleFilter('bg-green-300')">Appareil non rendu</span>
                    </div>
                    <div class="table--heading mt-2 devices__list__heading " style="padding-top: 20px;background:#FFF">
                        <p class="table--heading--col1">Image</p>
                        <p class="table--heading--col2">Client</p>
                        <p class="table--heading--col3">Marque</p>
                        <p class="table--heading--col4">Modèle</p>
                        <p class="table--heading--col5">Description de l'appareil</p>
                        <p class="table--heading--col6">actions</p>
                    </div>

                    <!-- device 1 -->
                    <div class="table--items devices__list__item" v-for="device in filteredDevices" :key="device.id" :class="getRowClass(device)">
                        <img :src="ourDeviceImage(device.image)" />
                        <p>{{ device.user.name }}</p>
                        <p>{{ device.brand }}</p>
                        <p>{{ device.model_name }}</p>
                        <p>{{ device.description }}</p>
                        <div>
                            <button class="btn-icon btn-icon-success" @click="onEdit(device.id)">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button v-if="!device.has_service" class="btn-icon btn-icon-danger" @click="deleteDevice(device.id)">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                        <div>
                            <Link href="/services/create" class="btn btn-secondary my-1" @click="redirectToServiceForm(device.id)">
                            Ajouter une prestation
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
                            @change="getDevices"
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

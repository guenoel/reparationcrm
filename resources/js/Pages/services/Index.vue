<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';
//import { useRoute, useRouter } from 'vue-router';

//const router = useRouter()

// defineProps({
//     services: {
//         type: Array,
//         required: true
//     }
// });

let services = ref([]);
let links = ref([]);
let searchQuery = ref('');

onMounted(async () => {
    getServices();
});

watch(searchQuery, () => {
    getServices();
});

//const newService = () => {
//    //router.push('/services/create')
//    Inertia.visit('/services/create')
//}


const getServices = async () => {
    try {
        const response = await axios.get('/api/services?&searchQuery=' + searchQuery.value);
        services.value = response.data.services.data;
        links.value = response.data.services.links;
    } catch (error) {
        console.error("Error fetching services:", error);
    }
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
                        <div class="customers__titlebar--item">
                            <Link href="/services/create" class="btn btn-secondary my-1">
                            Ajouter une prestation
                            </Link>
                            <!-- <button @click="newDevice">Ajouter un appareil</button> -->
                        </div>
                    </div>
                    <div class="relative">
                        <input class="search-input" type="text" name="search" placeholder="Recherche prestation..."
                            v-model="searchQuery" />
                    </div>

                    <div class="table--heading mt-2 services__list__heading " style="padding-top: 20px;background:#FFF">
                        <p class="table--heading--col1">Utilisateur</p>
                        <p class="table--heading--col2">Id appareil</p>
                        <p class="table--heading--col3">Marque</p>
                        <p class="table--heading--col4">Nom Modèle</p>
                        <p class="table--heading--col5">No Modèle</p>
                        <p class="table--heading--col6">Description de la prestation</p>
                        <p class="table--heading--col7">Price</p>
                        <p class="table--heading--col8">Actions</p>
                    </div>

                    <!-- device 1 -->
                    <div class="table--items services__list__item" v-for="service in services" :key="service.id">
                        <p>{{ service.device.user.name }}</p>
                        <p>{{ service.device_id }}</p>
                        <p>{{ service.device.brand }}</p>
                        <p>{{ service.device.model_name }}</p>
                        <p>{{ service.device.model_number }}</p>
                        <p>{{ service.description }}</p>
                        <p>{{ service.price }}</p>
                        <div>
                            <button class="btn-icon btn-icon-success" @click="onEdit(service.id)">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button class="btn-icon btn-icon-danger" @click="deleteService(service.id)">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    <div class="table--items devices__list__bottom">
                        <ul class="pagination">
                            <a href="#" class="btn btn-secondary" v-for="(link, index) in links" :key="index" v-html="link.label"
                                :class="{ active: link.active, disable: !link.url }" @click="changePage(link)"></a>
                        </ul>
                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

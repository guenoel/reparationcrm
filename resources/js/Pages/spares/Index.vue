<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';
//import { useRoute, useRouter } from 'vue-router';

//const router = useRouter()

// defineProps({
//     spares: {
//         type: Array,
//         required: true
//     }
// });

let spares = ref([]);
let links = ref([]);
let searchQuery = ref('');

onMounted(async () => {
    getSpares();
});

watch(searchQuery, () => {
    getSpares();
});

//const newSpare = () => {
//    //router.push('/spares/create')
//    Inertia.visit('/spares/create')
//}

const ourSpareImage = (img) => {
    return "/upload/" + img;
};

const getSpares = async () => {
    try {
        const response = await axios.get('/api/spares?&searchQuery=' + searchQuery.value);
        spares.value = response.data.spares.data;
        links.value = response.data.spares.links;
    } catch (error) {
        console.error("Error fetching spares:", error);
    }
};

const changePage = (link) => {
    if (!link.url || link.active) {
        return;
    }

    axios.get(link.url)
        .then((response) => {
            spares.value = response.data.spares.data;
            links.value = response.data.spares.links;
        });
};

const onEdit = (id) => {
    //router.push(`/spares/${id}/edit`)
    Inertia.visit(`/spares/${id}/edit`);
};

const deleteSpare = (id) => {
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
            axios.delete(`/api/spares/${id}`)
                .then(() => {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });
                    getSpares();
                });
        }
    });
};
</script>

<template>
    <Head title="Enregistrement pièce" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                <span>Pièces</span>
            </h2>
        </template>
        <template #default>
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="devices__list table">
                    <div class="customers__titlebar dflex justify-content-between align-items-center">
                        <div class="customers__titlebar--item">
                            <h1>Pièces</h1>
                        </div>
                        <div class="customers__titlebar--item">
                            <Link href="/spares/create" class="btn btn-secondary my-1">
                            Ajouter une pièce
                            </Link>
                            <!-- <button @click="newDevice">Ajouter un appareil</button> -->
                        </div>
                    </div>
                    <div class="relative">
                        <input class="search-input" type="text" name="search" placeholder="Recherche pièce..."
                            v-model="searchQuery" />
                    </div>

                    <div class="table--heading mt-2 services__list__heading " style="padding-top: 20px;background:#FFF">
                        <p class="table--heading--col1">Image</p>
                        <p class="table--heading--col2">Service ID</p>
                        <p class="table--heading--col3">Spare Type ID</p>
                        <p class="table--heading--col4">Description</p>
                        <p class="table--heading--col5">Date de commande</p>
                        <p class="table--heading--col6">Date de reception</p>
                        <p class="table--heading--col7">Date de retour</p>
                    </div>

                    <!-- device 1 -->
                    <div class="table--items services__list__item" v-for="spare in spares" :key="spare.id">
                        <!-- <p>{{ spare.device.service.spare_type.name }}</p> -->
                        <img :src="ourSpareImage(spare.image)" />
                        <p>{{ spare.service_id }}</p>
                        <p>{{ spare.spare_type_id }}</p>
                        <p>{{ spare.description }}</p>
                        <p>{{ spare.purchase_date }}</p>
                        <p>{{ spare.reception_date }}</p>
                        <p>{{ spare.return_date }}</p>
                        <div>
                            <button class="btn-icon btn-icon-success" @click="onEdit(spare.id)">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button class="btn-icon btn-icon-danger" @click="deleteSpare(spare.id)">
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

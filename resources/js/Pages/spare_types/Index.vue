<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';
//import { useRoute, useRouter } from 'vue-router';

//const router = useRouter()

// defineProps({
//     spare_types: {
//         type: Array,
//         required: true
//     }
// });

let spare_types = ref([]);
let links = ref([]);
let searchQuery = ref('');

onMounted(async () => {
    getSpareTypes();
});

watch(searchQuery, () => {
    getSpareTypes();
});

//const newSpareType = () => {
//    //router.push('/spare_types/create')
//    Inertia.visit('/spare_types/create')
//}

const ourSpareTypeImage = (img) => {
    return "/upload/" + img;
};

const getSpareTypes = async () => {
    try {
        const response = await axios.get('/api/spare_types?&searchQuery=' + searchQuery.value);
        spare_types.value = response.data.spare_types.data;
        links.value = response.data.spare_types.links;
    } catch (error) {
        console.error("Error fetching spare_types:", error);
    }
};

const changePage = (link) => {
    if (!link.url || link.active) {
        return;
    }

    axios.get(link.url)
        .then((response) => {
            spare_types.value = response.data.spare_types.data;
            links.value = response.data.spare_types.links;
        });
};

const onEdit = (id) => {
    //router.push(`/spare_types/${id}/edit`)
    Inertia.visit(`/spare_types/${id}/edit`);
};

const deleteSpareType = (id) => {
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
            axios.delete(`/api/spare_types/${id}`)
                .then(() => {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });
                    getSpareTypes();
                });
        }
    });
};
</script>

<template>
    <Head title="Enregistrement Type de pièce" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                <span>Type de pièces</span>
            </h2>
        </template>
        <template #default>
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="devices__list table">
                    <div class="customers__titlebar dflex justify-content-between align-items-center">
                        <div class="customers__titlebar--item">
                            <h1>Type de pièces</h1>
                        </div>
                        <div class="customers__titlebar--item">
                            <Link href="/spare_types/create" class="btn btn-secondary my-1">
                            Ajouter un type de pièce
                            </Link>
                            <!-- <button @click="newSpareType">Ajouter un type de pièce</button> -->
                        </div>
                    </div>
                    <div class="relative">
                        <input class="search-input" type="text" name="search" placeholder="Recherche d'type de pièce..."
                            v-model="searchQuery" />
                    </div>

                    <div class="table--heading mt-2 devices__list__heading " style="padding-top: 20px;background:#FFF">
                        <p class="table--heading--col1">Image</p>
                        <p class="table--heading--col2">Fournisseur</p>
                        <p class="table--heading--col3">Type</p>
                        <p class="table--heading--col4">Marque</p>
                        <p class="table--heading--col5">Description du type de pièce</p>
                        <p class="table--heading--col6">Prix d'achat</p>
                        <p class="table--heading--col7">Prix de vente</p>
                        <p class="table--heading--col8">actions</p>
                    </div>

                    <!-- device 1 -->
                    <div class="table--items devices__list__item" v-for="spare_type in spare_types" :key="spare_type.id">
                        <img :src="ourSpareTypeImage(spare_type.image)" />
                        <p>{{ spare_type.dealer }}</p>
                        <p>{{ spare_type.type }}</p>
                        <p>{{ spare_type.brand }}</p>
                        <p>{{ spare_type.description }}</p>
                        <p>{{ spare_type.buy_price }}</p>
                        <p>{{ spare_type.sell_price }}</p>
                        <div>
                            <button class="btn-icon btn-icon-success" @click="onEdit(spare_type.id)">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button class="btn-icon btn-icon-danger" @click="deleteSpareType(spare_type.id)">
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

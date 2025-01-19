<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';
//import { useRoute, useRouter } from 'vue-router';

//const router = useRouter()

// defineProps({
//     users: {
//         type: Array,
//         required: true
//     }
// });

let users = ref([]);
let links = ref([]);
let searchQuery = ref('');
const itemsPerPage = ref(10); // Valeur par défaut

onMounted(async () => {
    getUsers();
});

watch(searchQuery, () => {
    getUsers();
});

//const newUser = () => {
//    //router.push('/users/create')
//    Inertia.visit('/users/create')
//}

const ourUserImage = (img) => {
    return "/upload/" + img;
};

const getUsers = async () => {
    try {
        const response = await axios.get(`/api/users?searchQuery=${searchQuery.value}&perPage=${itemsPerPage.value}`);
        users.value = response.data.users.data;
        links.value = response.data.users.links;
    } catch (error) {
        console.error("Error fetching users:", error);
    }
};

const changePage = (link) => {
    if (!link.url || link.active) {
        return;
    }

    axios.get(link.url)
        .then((response) => {
            users.value = response.data.users.data;
            links.value = response.data.users.links;
        });
};

const onEdit = (id) => {
    //router.push(`/users/${id}/edit`)
    Inertia.visit(`/users/${id}/edit`);
};

</script>

<template>
    <Head title="Enregistrement Utilisateur" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                <span>Utilisateurs</span>
            </h2>
        </template>
        <template #default>
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="devices__list table">
                    <div class="customers__titlebar dflex justify-content-between align-items-center">
                        <div class="customers__titlebar--item">
                            <h1>Utilisateurs</h1>
                        </div>
                    </div>
                    <div class="relative">
                        <input class="search-input" type="text" name="search" placeholder="Recherche d'utilisateur..."
                            v-model="searchQuery" />
                    </div>

                    <div class="table--heading mt-2 devices__list__heading " style="padding-top: 20px;background:#FFF">
                        <p class="table--heading--col1">Image</p>
                        <p class="table--heading--col2">Nom</p>
                        <p class="table--heading--col3">e-mail</p>
                        <p class="table--heading--col4">Téléphone</p>
                        <p class="table--heading--col5">Rôle</p>
                        <p class="table--heading--col8">actions</p>
                    </div>

                    <!-- device 1 -->
                    <div class="table--items devices__list__item" v-for="user in users" :key="user.id">
                        <img :src="ourUserImage(user.image)" />
                        <p>{{ user.name }}</p>
                        <p>{{ user.email }}</p>
                        <p>{{ user.phone  }}</p>
                        <p>{{ user.role }}</p>
                        <div>
                            <button class="btn-icon btn-icon-success" @click="onEdit(user.id)">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                        </div>
                    </div>
                    <div class="table--items devices__list__bottom">
                        <ul class="pagination">
                            <a href="#" class="btn btn-secondary" v-for="(link, index) in links" :key="index" v-html="link.label"
                                :class="{ active: link.active, disable: !link.url }" @click="changePage(link)"></a>
                        </ul>
                        <select
                            v-model="itemsPerPage"
                            @change="getUsers"
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

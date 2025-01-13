<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';
//import { useRoute, useRouter } from 'vue-router';

//const router = useRouter()

// defineProps({
//     tasks: {
//         type: Array,
//         required: true
//     }
// });

let tasks = ref([]);
let links = ref([]);
let searchQuery = ref('');

onMounted(async () => {
    getTasks();
});

watch(searchQuery, () => {
    getTasks();
});

//const newTask = () => {
//    //router.push('/tasks/create')
//    Inertia.visit('/tasks/create')
//}

const ourTaskImage = (img) => {
    return "/upload/" + img;
};

const getTasks = async () => {
    try {
        const response = await axios.get('/api/tasks?&searchQuery=' + searchQuery.value);
        tasks.value = response.data.tasks.data;
        links.value = response.data.tasks.links;
    } catch (error) {
        console.error("Error fetching tasks:", error);
    }
};

const changePage = (link) => {
    if (!link.url || link.active) {
        return;
    }

    axios.get(link.url)
        .then((response) => {
            tasks.value = response.data.tasks.data;
            links.value = response.data.tasks.links;
        });
};

const onEdit = (id) => {
    //router.push(`/tasks/${id}/edit`)
    Inertia.visit(`/tasks/${id}/edit`);
};

const deleteTask = (id) => {
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
            axios.delete(`/api/tasks/${id}`)
                .then(() => {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });
                    getTasks();
                });
        }
    });
};

const formatTaskDate = (timestamp) => {
    if (!timestamp || timestamp === 0) {
        return "";
    }
    const date = new Date(timestamp);
    const formattedDate = date.toLocaleDateString('fr-FR'); // Date en format français
    const formattedTime = date.toLocaleTimeString('fr-FR'); // Heure en format français
    return { date: formattedDate, time: formattedTime };
};

</script>

<template>
    <Head title="Enregistrement tâche" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                <span>Tâches</span>
            </h2>
        </template>
        <template #default>
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="devices__list table">
                    <div class="customers__titlebar dflex justify-content-between align-items-center">
                        <div class="customers__titlebar--item">
                            <h1>Tâches</h1>
                        </div>
                        <div class="customers__titlebar--item">
                            <Link href="/tasks/create" class="btn btn-secondary my-1">
                            Ajouter une tâche
                            </Link>
                            <!-- <button @click="newDevice">Ajouter un appareil</button> -->
                        </div>
                    </div>
                    <div class="relative">
                        <input class="search-input" type="text" name="search" placeholder="Recherche tâche..."
                            v-model="searchQuery" />
                    </div>

                    <div class="table--heading mt-2 tasks__list__heading " style="padding-top: 20px;background:#FFF">
                        <p class="table--heading--col1">Image</p>
                        <p class="table--heading--col2">Prestation</p>
                        <p class="table--heading--col3">Technicien</p>
                        <p class="table--heading--col4">Début</p>
                        <p class="table--heading--col5">Fin</p>
                        <p class="table--heading--col6">Description</p>
                        <p class="table--heading--col7">Actions</p>
                    </div>

                    <!-- device 1 -->
                    <div class="table--items tasks__list__item" v-for="task in tasks" :key="task.id">
                        <!-- <p>{{ task.device.service.user.name }}</p> -->
                        <img :src="ourTaskImage(task.image)" />
                        <p>{{ task.service.device.user.name }} -> {{ task.service.device.brand }} {{ task.service.device.model_name }}<br>-> {{ task.service.description }}</p>
                        <p>{{ task.user.name }}</p>
                        <p>
                            {{ formatTaskDate(task.start).date }}<br>
                            {{ formatTaskDate(task.start).time }}
                        </p>
                        <p>
                            {{ formatTaskDate(task.end).date }}<br>
                            {{ formatTaskDate(task.end).time }}
                        </p>
                        <p>{{ task.description }}</p>
                        <div>
                            <button class="btn-icon btn-icon-success" @click="onEdit(task.id)">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button class="btn-icon btn-icon-danger" @click="deleteTask(task.id)">
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

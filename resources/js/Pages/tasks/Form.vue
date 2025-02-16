<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { reactive, ref, onMounted, computed, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
//import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';
import toast from 'sweetalert2';

const taskId = ref();

const form = reactive({
    service_id: '',
    spare_ids: [],
    start: '',
    end: '',
    description: '',
});

//const router = useRouter()

//const route = useRoute()


const page = usePage();
const editMode = ref(false);
let errors = ref([]);

onMounted(() => {
    // Check if there's a task ID to determine edit mode
    if (page.props.route && page.props.route.name === 'tasks.edit') {
        editMode.value = true;
        taskId.value = page.props.route.params.id;
        getTask();
    } else {
        getServices();
        getSpares();
        getUser();
    }
});

const getServices = async () => {
    try {
        let response = await axios.get('/api/services?all=true');
        page.props.services = response.data.services;
        const params = new URLSearchParams(window.location.search);
        form.service_id = params.get('service_id'); // Preselect the service ID
    } catch (error) {
        console.error("Error fetching services:", error);
    }
};

const getSpares = async () => {
    try {
        const params = new URLSearchParams(window.location.search);
        form.service_id = params.get('service_id');

        if (!form.service_id) {
            console.error("Service ID is missing, unable to fetch spares.");
            return;
        }

        let response = await axios.get(`/api/spares?service_id=${form.service_id}`); //&all=true
        // Extraire uniquement les spares depuis la clé "data"
        page.props.spares = response.data.spares.data || [];
        console.log("Fetched spares:", page.props.spares);
    } catch (error) {
        console.error("Error fetching spares:", error);
    }
};


const getUser = async () => {
    try {
        form.user_id = page.props.auth.user.id;
    } catch (error) {
        console.error("Error fetching user:", error);
    }
};

const getTask = async () => {
    try {
        let response = await axios.get(`/api/tasks/${taskId.value}/edit`)
        // Transformer l'objet services en tableau
        if (response.data.services) {
            page.props.services = Object.entries(response.data.services).map(([id, description]) => ({
                id: Number(id),
                description
            }));
        }
        // Transformer l'objet spares en tableau
        if (response.data.spares) {
            page.props.spares = Object.entries(response.data.spares).map(([id, description]) => ({
                id: Number(id),
                description
            }));
        }

        if (response.data.task) {
            form.service_id = response.data.task.service_id;
            form.user_id = response.data.task.user_id;
            form.spare_ids = response.data.task.spares.map(spare => spare.id) || [];
            form.start = response.data.task.start;
            form.end = response.data.task.end;
            form.description = response.data.task.description;

            // Récupérer uniquement les spares associés au service_id de la tâche
            const sparesResponse = await axios.get(`/api/spares?service_id=${form.service_id}`);
            page.props.spares = sparesResponse.data.spares.data || [];
        }
            
    } catch (error) {
        console.error("Error fetching task data:", error);
    }
};

const getImage = () => {
    let image = "/upload/no-image.jpg";
    if (form.image) {
        if (form.image.indexOf('base64') != -1) {
            image = form.image;
        } else {
            image = "/upload/" + form.image;
        }
    }
    return image;
};

const handleFileChange = (e) => {
    const target = e.target;
    let file = target.files ? target.files[0] : null;

    if (file) {
        const reader = new FileReader();
        reader.onloadend = (file) => {
            if (reader.result) {
                form.image = reader.result;
            }
        };
        reader.readAsDataURL(file);
    }
};

const handleSave = (values, actions) => {
    if (editMode.value) {
        updateTask(values, actions);
    } else {
        createTask(values, actions);
    }
};

const createTask = (values, actions) => {
    axios.post('/api/tasks', form)
        .then((response) => {
            toast.fire({ icon: "success", title: "Appareil ajouté" });
            setTimeout(() => {
                Inertia.visit('/tasks/index/');
            }, 2000);
        })
        .catch((error) => {
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else {
                console.error("Error creating task:", error);
            }
        });
};

const updateTask = (values, actions) => {
    axios.put(`/api/tasks/${taskId.value}`, form)
        .then((response) => {
            toast.fire({ icon: "success", title: "Appareil modifié" });
            setTimeout(() => {
                Inertia.visit('/tasks/index/');
        }, 2000);
        })
        .catch((error) => {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else {
                console.error("Error creating task:", error);
            }
        });
};
</script>

<template>
    <Head title="Enregistrement d'une tâche" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                <span v-if="editMode">Modification d'une tâche</span>
                <span v-else>Nouvelle tâche</span>
            </h2>
        </template>
        <template #default>
            <div class="tasks__create ">
                <div class="tasks__create__titlebar dflex justify-content-between align-items-center">
                    <div class="tasks__create__titlebar--item">
                        <button class="btn btn-secondary ml-1">Save</button>
                    </div>
                </div>

                <div class="tasks__create__cardWrapper mt-2">
                    <div class="tasks__create__main">
                        <div class="tasks__create__main--addInfo card py-2 px-2 bg-white">
                            <p class="mb-1">Service</p>
                            <select v-model="form.service_id" class="input" id="service_id" name="service_id">
                                <option v-for="service in page.props.services" :key="service.id" :value="service.id">
                                    {{ service.description }}
                                </option>
                            </select>
                            <small style="color:red" v-if="errors.service_id">{{ errors.service_id }}</small>
                            <p class="mb-1">Pièces</p>
                            <select v-model="form.spare_ids" class="input" id="spare_ids" name="spare_ids" multiple>
                                <option v-if="Array.isArray(page.props.spares) && page.props.spares.length > 0"
                                        v-for="spare in page.props.spares"
                                        :key="spare.id"
                                        :value="spare.id"
                                >
                                    {{ spare.description }}
                                </option>
                            </select>
                            <small style="color:red" v-if="errors.spare_ids">{{ errors.spare_ids }}</small>

                            <p class="mb-1">Début de la tâche</p>
                            <input type="datetime-local" class="input" id="start" name="start" v-model="form.start" />
                            <small style="color:red" v-if="errors.start">{{ errors.start }}</small>

                            <p class="mb-1">Fin de la tâche</p>
                            <input type="datetime-local" class="input" id="end" name="end" v-model="form.end" />
                            <small style="color:red" v-if="errors.end">{{ errors.end }}</small>

                            <p class="my-1">Description</p>
                            <textarea cols="10" rows="5" class="textarea" id="description" name="description" v-model="form.description"></textarea>
                            <small style="color:red" v-if="errors.description">{{ errors.description }}</small>

                            <div class="devices__create__main--media--images mt-2">
                                <ul class="devices__create__main--media--images--list list-unstyled">
                                    <li class="devices__create__main--media--images--item">
                                        <div class="devices__create__main--media--images--item--imgWrapper">
                                            <img :src="getImage()"
                                                class="devices__create__main--media--images--item--img" alt="" />
                                        </div>
                                    </li>
                                    <!-- upload image small -->
                                    <li class="devices__create__main--media--images--item">
                                        <form class="devices__create__main--media--images--item--form">
                                            <label class="devices__create__main--media--images--item--form--label"
                                                for="myfile">Add Image</label>
                                            <input class="devices__create__main--media--images--item--form--input"
                                                type="file" id="myfile" @change="handleFileChange">
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer Bar -->
                <div class="dflex justify-content-between align-items-center my-3">
                    <p></p>
                    <button class="btn btn-secondary" @click="handleSave">Save</button>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>
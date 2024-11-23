<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { reactive, ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
//import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';
import toast from 'sweetalert2';

const serviceId = ref();

const form = reactive({
    device_id: '',
    description: '',
    price: '',
});

//const router = useRouter()

//const route = useRoute()


const page = usePage();
const editMode = ref(false);
let errors = ref([]);

onMounted(() => {
    // Check if there's a service ID to determine edit mode
    if (page.props.route && page.props.route.name === 'services.edit') {
        editMode.value = true;
        serviceId.value = page.props.route.params.id;
        getService();
    } else {
        getDevices();
    }
});

const getDevices = async () => {
    try {
        let response = await axios.get('/api/services/create');
        page.props.devices = response.data.devices;
    } catch (error) {
        console.error("Error fetching devices:", error);
    }
};

const getService = async () => {
    try {
        let response = await axios.get(`/api/services/${serviceId.value}/edit`)
            //.then((response) => {
            if (response.data.service) {
                form.device_id = response.data.service.device_id;
                form.description = response.data.service.description;
                form.price = response.data.service.price;
            //});
            }
            if (response.data.devices) {
            page.props.devices = response.data.devices; // Chargez les utilisateurs si nécessaire
            }
            
    } catch (error) {
        console.error("Error fetching service data:", error);
    }
};

const handleSave = (values, actions) => {
    if (editMode.value) {
        updateService(values, actions);
    } else {
        createService(values, actions);
    }
};

const createService = (values, actions) => {
    axios.post('/api/services', form)
        .then((response) => {
            toast.fire({ icon: "success", title: "Appareil ajouté" });
            setTimeout(() => {
                Inertia.visit('/services/index/');
            }, 2000);
        })
        .catch((error) => {
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else {
                console.error("Error creating service:", error);
            }
        });
};

const updateService = (values, actions) => {
    axios.put(`/api/services/${serviceId.value}`, form)
        .then((response) => {
            toast.fire({ icon: "success", title: "Appareil modifié" });
            setTimeout(() => {
                Inertia.visit('/services/index/');
        }, 2000);
        })
        .catch((error) => {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else {
                console.error("Error creating service:", error);
            }
        });
};
</script>

<template>
    <Head title="Enregistrement Appareil" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                <span v-if="editMode">Modification d'une prestation</span>
                <span v-else>Nouvelle prestation</span>
            </h2>
        </template>
        <template #default>
            <div class="services__create ">
                <div class="services__create__titlebar dflex justify-content-between align-items-center">
                    <div class="services__create__titlebar--item">
                        <button class="btn btn-secondary ml-1">Save</button>
                    </div>
                </div>

                <div class="services__create__cardWrapper mt-2">
                    <div class="services__create__main">
                        <div class="services__create__main--addInfo card py-2 px-2 bg-white">
                            <p class="mb-1">Appareil</p>
                            <select v-model="form.device_id" class="input" id="device_id" name="device_id">
                                <option v-for="(name, id) in page.props.devices" :key="id" :value="id">{{ name }}</option>
                            </select>
                            <small style="color:red" v-if="errors.device_id">{{ errors.device_id }}</small>
                            <p class="my-1">Description</p>
                            <textarea cols="10" rows="5" class="textarea" id="description" name="description" v-model="form.description"></textarea>
                            <small style="color:red" v-if="errors.description">{{ errors.description }}</small>
                            <p class="mb-1">Prix</p>
                            <input type="text" class="input" id="price" name="price" v-model="form.price">
                            <small style="color:red" v-if="errors.price">{{ errors.price }}</small>
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
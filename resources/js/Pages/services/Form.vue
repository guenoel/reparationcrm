<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { reactive, ref, onMounted, computed, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
//import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';
import toast from 'sweetalert2';

const serviceId = ref();

const form = reactive({
    device_id: '',
    description: '',
    accepted: false,
    deposit: null,
    deposit_paid: false,
    price: null,
    price_paid: false,
    done: false
});

//const router = useRouter()

//const route = useRoute()


const page = usePage();
const editMode = ref(false);
//const createMode = ref(false);
let errors = ref([]);
const customerView = ref(false); // To control dropdown visibility
//const devices = ref([]);
const deviceInfo = ref(null);
const devicesDropdown = ref([]);
const searchQuery = ref(''); // Stocke le texte de recherche

onMounted(() => {
    // Check user role and set dropdown visibility
    const authUser = page.props.auth.user;
    if (authUser && authUser.role === 0) {
        customerView.value = true;
    }
    // Check if there's a service ID to determine edit mode
    if (page.props.route && page.props.route.name === 'services.edit') {
        editMode.value = true;
        serviceId.value = page.props.route.params.id;
        getService();
    } else {
        // if (page.props.route && page.props.route.name === 'services.create') {
        //     createMode.value = true;
        // } else {
        getDevices();
        // }
    }
    console.log("Edit Mode:", editMode.value);
});

// Filtrer les appareils avec `user.name`, `brand`, et `model_name`
const filteredDevices = computed(() => {
    if (!searchQuery.value.trim()) {
        return devicesDropdown.value; // Retourne tous les appareils si la recherche est vide
    }

    const searchLower = searchQuery.value.toLowerCase();

    // Convertir l'objet en tableau, appliquer le filtre, puis le reconvertir en objet
    return Object.fromEntries(
        Object.entries(devicesDropdown.value).filter(([id, label]) => {
            return label.toLowerCase().includes(searchLower);
        })
    );
});

watch(filteredDevices, (newDevices) => {
    if (Object.keys(newDevices).length > 0) {
        form.device_id = Object.keys(newDevices)[0]; // Prend le premier appareil filtré
    }
});

const getDevices = async () => {
        
    const params = new URLSearchParams(window.location.search);
    const deviceId = params.get('device_id');

    try {
        const response = await axios.get(`/api/services/create${deviceId ? `?device_id=${deviceId}` : ''}`);
        
        if (response.data.device) {
            deviceInfo.value = response.data.device; // Appareil spécifique
            form.device_id = deviceId; // Pré-sélectionner le device_id dans le formulaire
            console.log("Device Info:", deviceInfo.value);
        }

        if (response.data.devices) {
            devicesDropdown.value = response.data.devices; // Liste dropdown
            console.log("Devices Dropdown:", devicesDropdown.value);
        }
    } catch (error) {
        console.error("Error fetching data:", error);
    }
};

const getService = async () => {
    try {
            let response = await axios.get(`/api/services/${serviceId.value}/edit`)
            // response: le service demandé + list of devices avec infos concaténées
            console.log("Service Response:", response.data);
            // Transformer l'objet devices en tableau
            if (response.data.devices) {
                page.props.devices = Object.entries(response.data.devices).map(([id, label]) => ({
                    id: Number(id),
                    label: label
                }));
            }

            if (response.data.service) {
                form.device_id = response.data.service.device_id;
                form.device = response.data.service.device;
                form.description = response.data.service.description;
                form.accepted = Boolean(response.data.service.accepted);
                form.deposit = response.data.service.deposit;
                form.deposit_paid = Boolean(response.data.service.deposit_paid);
                form.price = response.data.service.price;
                form.price_paid = Boolean(response.data.service.price_paid);
                form.done = Boolean(response.data.service.done);
                form.returned = Boolean(response.data.service.device.returned);
            }

        } catch (error) {
            console.error("Error fetching service data:", error);
        }
};

const handleSave = (values, actions) => {
    if (editMode.value) {
        console.log('Updating service:', JSON.stringify(form, null, 2));
        updateService(values, actions);
    } else {
        console.log('Creating service:', JSON.stringify(form, null, 2));
        createService(values, actions);
    }
};

const createService = (values, actions) => {
    axios.post('/api/services', form)
        .then((response) => {
            toast.fire({ icon: "success", title: "Appareil ajouté" });
            setTimeout(() => {
                window.open(`/services/${response.data.service_id}/ticket`, '_blank');
                Inertia.visit('/services/index/');
            }, 2000);
        })
        .catch((error) => {
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors;
                console.error("Validation errors:", error.value);
            } else {
                console.error("Error creating service:", error);
            }
        });
        console.log('Form data being sent:', JSON.stringify(form, null, 2));
};

const updateService = (values, actions) => {
    axios.put(`/api/services/${serviceId.value}`, form)
        .then((response) => {
            toast.fire({ icon: "success", title: "Appareil modifié" });
            setTimeout(() => {
                window.open(`/services/${serviceId.value}/ticket`, '_blank');
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
                            <p class="mb-1">Appareil:</p>
                            <!-- édition admin -->
                            <div v-if="!customerView && editMode" class="device-info">
                                <p class="mb-1">
                                    {{ form.device?.user?.name }} -> {{ form.device?.brand }} {{ form.device?.model_name }}
                                </p>
                            </div>
                            <!-- édition user -->
                            <div v-if="customerView && editMode" class="device-info">
                                <p class="mb-1">
                                    {{ form.device?.brand }} {{ form.device?.model_name }}
                                </p>
                            </div>
                            <!-- création pré-select admin -->
                            <div v-if="!customerView && deviceInfo" class="device-info">
                                <p class="mb-1">
                                    {{ deviceInfo.user.name }} -> {{ deviceInfo.brand }} {{ deviceInfo.model_name }}
                                </p>
                            </div>
                            <!-- création pré-select user -->
                            <div v-if="customerView && deviceInfo" class="device-info">
                                <p class="mb-1">
                                    {{ deviceInfo.brand }} {{ deviceInfo.model_name }}
                                </p>
                            </div>
                            <!-- création -->
                            <div v-if="!editMode && !deviceInfo">
                                <input
                                    type="text"
                                    v-model="searchQuery"
                                    placeholder="Rechercher par utilisateur, marque ou modèle..."
                                    class="input mb-2"
                                />

                                <select v-model="form.device_id" class="input">

                                    <option
                                        v-for="[id, label] in Object.entries(filteredDevices)"
                                        :key="id"
                                        :value="id"
                                    >
                                        {{ label }}
                                    </option>
                                </select>

                                <small style="color:red" v-if="errors.device_id">{{ errors.device_id }}</small>
                            </div>
                            
                            <!-- Ne s'affiche pas pour le client si le prix est fixé -->
                            <div v-if="!(customerView && form.price != null)">
                                <p class="my-1">Description du service demandé:</p>
                                <textarea cols="10" rows="5" class="textarea" id="description" name="description" v-model="form.description"></textarea>
                                <small style="color:red" v-if="errors.description">{{ errors.description }}</small>
                            </div>
                            <!-- S'affiche pour le client si le prix est fixé -->
                            <div v-if="customerView && form.price != null">
                                <p class="mb-1">
                                    Service demandé:<br>{{ form.description }}
                                </p>
                            </div>
                            <!-- Vue coté boutique -->
                            <div v-if="!customerView && form.price_paid == false">
                                <p class="mb-1">Accompte</p>
                                <input type="text" class="input" id="deposit" name="deposit" v-model="form.deposit">
                                <small style="color:red" v-if="errors.price">{{ errors.deposit }}</small>
                            </div>
                            <!-- Vue coté client -->
                            <div v-if="customerView && editMode && form.price_paid == false">
                                <p class="my-1">Accompte: {{ form.deposit }}</p>
                            </div>
                            <!-- Vue coté boutique -->
                            <div v-if="!customerView && form.price != null && form.price_paid == false">
                                <p class="mb-1">
                                <input type="checkbox" id="deposit_paid" name="deposit_paid" v-model="form.deposit_paid">
                                Accompte payé ?</p>
                            </div>
                            
                            <!-- Vue coté boutique -->
                            <div v-if="!customerView">
                                <p class="mb-1">Prix</p>
                                <input type="text" class="input" id="price" name="price" v-model="form.price">
                            </div>
                            <!-- Vue coté client -->
                            <div v-if="customerView && editMode && form.price != null">
                                <p class="my-1">Tarif: {{ form.price }}</p>
                            </div>
                            <!-- Vue coté boutique et client-->
                            <div v-if="editMode && form.price == null">
                                <p class="mb-1">En attente d'un tarif</p>
                            </div>
                            <!-- Vue coté boutique -->
                            <div v-if="!customerView && form.price != null">
                                <p class="mb-1">
                                <input type="checkbox" id="accepted" name="accepted" v-model="form.accepted">
                                Devis accepté ?</p>
                            </div>
                            
                            <!-- Vue coté client -->
                            <div v-if="customerView && editMode && form.accepted == false && form.price != null">
                                <p class="mb-1">
                                <input type="checkbox" id="accepted" name="accepted" v-model="form.accepted">
                                Cochez la case pour accepter le devis</p>
                            </div>
                            <div v-if="customerView && editMode && form.accepted == true">
                                <p class="my-1">Devis accepté</p>
                            </div>
                            <!-- Vue coté boutique -->
                            <div v-if="!customerView && form.price != null">
                                <p class="mb-1">
                                <input type="checkbox" id="done" name="done" v-model="form.done">
                                Service rendu ?</p>
                            </div>
                            <div v-if="form.done == true">
                                <p class="my-1">Votre appareil est prêt !</p>
                            </div>
                            <div v-if="form.done == false && editMode">
                                <p class="my-1">Service en cours...</p>
                            </div>
                            <!-- Vue coté boutique -->
                            <div v-if="!customerView && form.price != null">
                                <p class="mb-1">
                                <input type="checkbox" id="price_paid" name="price_paid" v-model="form.price_paid">
                                Service payé ?</p>
                            </div>
                            <!-- Vue coté client -->
                            <div v-if="form.price_paid == true">
                                <p class="my-1">Payé !</p>
                            </div>
                            <div v-if="form.price_paid == false && form.done == true">
                                <p class="my-1">En attente de paiement</p>
                            </div>
                            <!-- Vue coté boutique -->
                            <div v-if="!customerView">
                                <p class="mb-1">
                                <input type="checkbox" id="returned" name="returned" v-model="form.returned">
                                Appareil restitué ?</p>
                            </div>
                            <!-- Vue coté client -->
                            <div v-if="form.returned == true">
                                <p class="my-1">Appareil restitué</p>
                            </div>
                            <div v-if="form.returned == false">
                                <p class="my-1">Appareil en magasin</p>
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
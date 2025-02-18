<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { reactive, ref, onMounted, computed, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
//import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';
import toast from 'sweetalert2';

const deviceId = ref();

const form = reactive({
    image: '',
    user_id: '',
    brand: '',
    model_name: '',
    model_number: '',
    color: '',
    serial_number: '',
    imei: '',
    description: '',
    returned: ''
});

//const router = useRouter()

//const route = useRoute()


const page = usePage();
const editMode = ref(false);
let errors = ref([]);
const hideUserDropdown = ref(false); // To control dropdown visibility
const searchQuery = ref(''); // Stocke le texte de recherche
const brands = ref([]); // Stocke la liste des marques
const models = ref([]); // Stocke la liste des modèles de la marque sélectionnée
const modelNumbers = ref([]); // Stocke la liste des numéros de modèles du modèle sélectionné

onMounted(() => {
    // Check user role and set dropdown visibility
    const authUser = page.props.auth.user;
    if (authUser && authUser.role === 0) {
        hideUserDropdown.value = true;
        form.user_id = authUser.id; // Pre-fill authenticated user's ID
    }
    // Check if there's a device ID to determine edit mode
    if (page.props.route && page.props.route.name === 'devices.edit') {
        editMode.value = true;
        deviceId.value = page.props.route.params.id;
        getDevice();
    } else {
        getUsers(); // Charger les utilisateurs dès que la page est chargée
        getBrands(); // Charger les marques dès que la page est chargée
    }
});

// Propriété calculée pour filtrer les utilisateurs
const filteredUsers = computed(() => {
    if (!searchQuery.value.trim()) {
        return page.props.users; // Retourne tous les utilisateurs si la recherche est vide
    }
    return page.props.users.filter((user) =>
        user.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

watch(filteredUsers, (newUsers) => {
    if (newUsers.length > 0) {
        form.user_id = newUsers[0].id; // Prend le premier utilisateur filtré par le champ de recherche
    }
});

watch(() => form.brand, async (newBrand) => {
    if (newBrand) {
        try {
            const response = await axios.get(`/api/models/${newBrand}`);
            models.value = response.data.map(item => item.modelValue);
            form.model_name = ''; // Réinitialiser la sélection du modèle
            modelNumbers.value = []; // Réinitialiser les numéros de modèle
        } catch (error) {
            console.error("Erreur lors de la récupération des noms de modèle :", error);
        }
    }
});

watch(() => form.model_name, async (newModel) => {
    if (newModel) {
        try {
            const response = await axios.get(`/api/model-numbers/${form.brand}/${newModel}`);
            // Vérifie que response.data est bien un tableau
            modelNumbers.value = Array.isArray(response.data) ? response.data : [];
            form.model_number = '';
        } catch (error) {
            console.error("Erreur lors de la récupération des numéros de modèle :", error);
        } 
    }
});

const getBrands = async () => {
    try {
        const response = await axios.get('/api/brands');
        brands.value = response.data.map(item => item.brandValue);
    } catch (error) {
        console.error("Erreur lors de la récupération des marques :", error);
    }
};


const getUsers = async () => {
    try {
            let response = await axios.get('/api/users/new_form');
            page.props.users = response.data.users;
            // for pre-selecting user in dropdown menu
            const params = new URLSearchParams(window.location.search);
            if (!form.user_id) {
                form.user_id = params.get('user_id');
            }
        } catch (error) {
            console.error("Error fetching users:", error);
        }
};

const getDevice = async () => {
    try {
        let response = await axios.get(`/api/devices/${deviceId.value}/edit`)
            // Transformer l'objet users en tableau
            if (response.data.users) {
                page.props.users = Object.entries(response.data.users).map(([id, name]) => ({
                    id: Number(id),
                    name
                }));
            }

            if (response.data.device) {
                form.image = response.data.device.image;
                form.user_id = response.data.device.user_id;
                form.brand = response.data.device.brand;
                form.model_name = response.data.device.model_name;
                form.model_number = response.data.device.model_number;
                form.color = response.data.device.color;
                form.serial_number = response.data.device.serial_number;
                form.imei = response.data.device.imei;
                form.description = response.data.device.description;
                form.returned = response.data.device.returned;
                form.has_service = Boolean(response.data.device.has_service);
            }

    } catch (error) {
        console.error("Error fetching device data:", error);
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
        updateDevice(values, actions);
    } else {
        createDevice(values, actions);
    }
};

const createDevice = (values, actions) => {
    console.log('Form data being sent:', JSON.stringify(form, null, 2));
    axios.post('/api/devices', form)
        .then((response) => {
            toast.fire({
                icon: "success",
                title: "Appareil ajouté",
                timer: 2000,
                showConfirmButton: false
            });
            setTimeout(() => {
                Inertia.visit('/devices/index/');
            }, 2000);
        })
        .catch((error) => {
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else {
                console.error("Error creating device:", error);
            }
        });
        console.log('Form data being sent:', JSON.stringify(form, null, 2));
};

const updateDevice = (values, actions) => {
    axios.put(`/api/devices/${deviceId.value}`, form)
        .then((response) => {
            toast.fire({ icon: "success", title: "Appareil modifié" });
            setTimeout(() => {
                Inertia.visit('/devices/index/');
        }, 2000);
        })
        .catch((error) => {
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else {
                console.error("Error creating device:", error);
            }
        });
};
</script>

<template>
    <Head title="Enregistrement Appareil" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                <span v-if="editMode">Modification d'un appareil</span>
                <span v-else>Nouvel Appareil</span>
            </h2>
        </template>
        <template #default>
            <div class="devices__create ">
                <div class="devices__create__titlebar dflex justify-content-between align-items-center">
                    <div class="devices__create__titlebar--item">
                        <button class="btn btn-secondary ml-1">Save</button>
                    </div>
                </div>

                <div class="devices__create__cardWrapper mt-2">
                    <div class="devices__create__main">
                        <div class="devices__create__main--addInfo card py-2 px-2 bg-white">
                            <div v-if="!hideUserDropdown">
                                <p class="mb-1">Utilisateur</p>
                                <input
                                    type="text"
                                    v-model="searchQuery"
                                    placeholder="Rechercher un utilisateur..."
                                    class="input mb-2"
                                />
                                <select v-model="form.user_id" class="input" id="user_id" name="user_id">
                                    <!-- <option v-for="user in page.props.users" :key="user.id" :value="user.id">
                                        {{ user.name }}
                                    </option> -->
                                    <option
                                        v-for="user in filteredUsers"
                                        :key="user.id"
                                        :value="user.id"
                                    >
                                        {{ user.name }}
                                    </option>
                                </select>
                                <small style="color:red" v-if="errors.user_id">{{ errors.user_id }}</small>
                            </div>
                            <!-- coté client, si pas de services associé -->
                            <div v-if="!hideUserDropdown || !editMode || (hideUserDropdown && editMode && !form.has_service)">
                                <p class="mb-1">Marque</p>
                                <select v-model="form.brand" class="input">
                                    <option value="">Sélectionner une marque</option>
                                    <option v-for="brand in brands" :key="brand" :value="brand">
                                        {{ brand }}
                                    </option>
                                </select>
                                <small style="color:red" v-if="errors.brand">{{ errors.brand }}</small>

                                <p class="mb-1">Modèle</p>
                                <select v-model="form.model_name" class="input" :disabled="!form.brand">
                                    <option value="">Sélectionner un modèle</option>
                                    <option v-for="model in models" :key="model" :value="model">
                                        {{ model }}
                                    </option>
                                </select>
                                <small style="color:red" v-if="errors.model_name">{{ errors.model_name }}</small>

                                <p class="mb-1">Numéro de modèle</p>
                                <select v-model="form.model_number" class="input" :disabled="!form.model_name">
                                    <option value="">Sélectionner un numéro de modèle</option>
                                    <option v-for="number in modelNumbers" :key="number" :value="number">
                                        {{ number }}
                                    </option>
                                </select>
                                <small style="color:red" v-if="errors.model_number">{{ errors.model_number }}</small>

                                <p class="mb-1">Couleur</p>
                                <input type="text" class="input" id="color" name="color" v-model="form.color">
                                <p class="mb-1">No de série</p>
                                <input type="text" class="input" id="serial_number" name="serial_number" v-model="form.serial_number">
                                <p class="mb-1">imei</p>
                                <input type="text" class="input" id="imei" name="imei" v-model="form.imei">
                                <p class="my-1">Description (optional)</p>
                                <textarea cols="10" rows="5" class="textarea" id="description" name="description" v-model="form.description"></textarea>
                            </div>
                            <div v-if="hideUserDropdown && editMode && form.has_service">
                                <p class="mb-1">Marque: {{ form.brand }}</p>
                                <p class="mb-1">Nom de modèle: {{ form.model_name }}</p>
                                <p class="mb-1">Numéro de modèle: {{ form.model_number }}</p>
                                <p class="mb-1">Couleur: {{ form.color }}</p>
                                <p class="mb-1">Numéro de série: {{ form.serial_number }}</p>
                                <p class="mb-1">imei: {{ form.imei }}</p>
                                <p class="mb-1">Description: {{ form.description }}</p>
                            </div>
                            <div v-if="!hideUserDropdown">
                                <p class="mb-1">Restitué au client ?</p>
                                <select v-model="form.returned" class="input" id="returned" name="returned" default="0">
                                    <option value="0">Non</option>
                                    <option value="1">Oui</option>
                                </select>
                            </div>
                            <div v-if="hideUserDropdown && form.returned == 0 && editMode">
                                <p>Appareil non restitué</p>
                            </div>
                            <div v-if="hideUserDropdown && form.returned == 1 && editMode">
                                <p>Appareil restitué</p>
                            </div>
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
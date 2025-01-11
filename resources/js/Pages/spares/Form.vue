<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { reactive, ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
//import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';
import toast from 'sweetalert2';

const spareId = ref();

const form = reactive({
    image: '',
    service_id: '',
    spare_type_id: '',
    purchase_date: '',
    reception_date: '',
    description: '',
});

//const router = useRouter()

//const route = useRoute()


const page = usePage();
const editMode = ref(false);
let errors = ref([]);

onMounted(() => {
    // Check if there's a spare ID to determine edit mode
    if (page.props.route && page.props.route.name === 'spares.edit') {
        editMode.value = true;
        spareId.value = page.props.route.params.id;
        getSpare();
    } else {
        getServices();
        getSpareTypes();
    }
});

const getServices = async () => {
    try {
        let response = await axios.get('/api/services');
        page.props.services = response.data.services.data;
    } catch (error) {
        console.error("Error fetching services:", error);
    }
};

const getSpareTypes = async () => {
    try {
        let response = await axios.get('/api/spare_types');
        page.props.spare_types = response.data.spare_types.data;
    } catch (error) {
        console.error("Error fetching spare_types:", error);
    }
};

const getSpare = async () => {
    try {
        let response = await axios.get(`/api/spares/${spareId.value}/edit`)
            //.then((response) => {
            if (response.data.spare) {
                form.image = response.data.spare.image;
                form.service_id = response.data.spare.service_id;
                form.spare_type_id = response.data.spare.spare_type_id;
                form.description = response.data.spare.description;
                form.purchase_date = response.data.spare.purchase_date;
                form.reception_date = response.data.spare.reception_date;
                form.return_date = response.data.spare.return_date;
            //});
            }
            if (response.data.services) {
            page.props.services = response.data.services; // Chargez les services si nécessaire
            }
            if (response.data.spare_type_id) {
            page.props.spare_type_id = response.data.spare_type_id; // Chargez les types de pièces si nécessaire
            }
            
    } catch (error) {
        console.error("Error fetching spare data:", error);
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
        updateSpare(values, actions);
    } else {
        createSpare(values, actions);
    }
};

const createSpare = (values, actions) => {
    axios.post('/api/spares', form)
        .then((response) => {
            toast.fire({ icon: "success", title: "Appareil ajouté" });
            setTimeout(() => {
                Inertia.visit('/spares/index/');
            }, 2000);
        })
        .catch((error) => {
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else {
                console.error("Error creating spare:", error);
            }
        });
};

const updateSpare = (values, actions) => {
    axios.put(`/api/spares/${spareId.value}`, form)
        .then((response) => {
            toast.fire({ icon: "success", title: "Appareil modifié" });
            setTimeout(() => {
                Inertia.visit('/spares/index/');
        }, 2000);
        })
        .catch((error) => {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else {
                console.error("Error creating spare:", error);
            }
        });
};
</script>

<template>
    <Head title="Enregistrement d'une pièce" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                <span v-if="editMode">Modification d'une pièce</span>
                <span v-else>Nouvelle pièce</span>
            </h2>
        </template>
        <template #default>
            <div class="spares__create ">
                <div class="spares__create__titlebar dflex justify-content-between align-items-center">
                    <div class="spares__create__titlebar--item">
                        <button class="btn btn-secondary ml-1">Save</button>
                    </div>
                </div>

                <div class="spares__create__cardWrapper mt-2">
                    <div class="spares__create__main">
                        <div class="spares__create__main--addInfo card py-2 px-2 bg-white">
                            <p class="mb-1">Service ID</p>
                            <select v-model="form.service_id" class="input" id="service_id" name="service_id">
                                <option v-for="service in page.props.services" :key="service.id" :value="service.id">{{ service.description }}</option>
                            </select>
                            <small style="color:red" v-if="errors.service_id">{{ errors.service_id }}</small>

                            <p class="mb-1">Pièce type ID</p>
                            <select v-model="form.spare_type_id" class="input" id="spare_type_id" name="spare_type_id">
                                <option v-for="spare_type in page.props.spare_types" :key="spare_type.id" :value="spare_type.id">{{ spare_type.dealer }} {{ spare_type.type }}</option>
                            </select>
                            <small style="color:red" v-if="errors.spare_type_id">{{ errors.spare_type_id }}</small>

                            <p class="my-1">Description</p>
                            <textarea cols="10" rows="5" class="textarea" id="description" name="description" v-model="form.description"></textarea>
                            <small style="color:red" v-if="errors.description">{{ errors.description }}</small>

                            <p class="mb-1">Date d'achat</p>
                            <input type="datetime-local" class="input" id="purchase_date" name="purchase_date" v-model="form.purchase_date" />
                            <small style="color:red" v-if="errors.purchase_date">{{ errors.purchase_date }}</small>

                            <p class="mb-1">Date de reception</p>
                            <input type="datetime-local" class="input" id="reception_date" name="reception_date" v-model="form.reception_date" />
                            <small style="color:red" v-if="errors.reception_date">{{ errors.reception_date }}</small>

                            <p class="mb-1">Date de retour</p>
                            <input type="datetime-local" class="input" id="return_date" name="return_date" v-model="form.return_date" />
                            <small style="color:red" v-if="errors.return_date">{{ errors.return_date }}</small>

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
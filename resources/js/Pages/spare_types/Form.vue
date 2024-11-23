<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { reactive, ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
//import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';
import toast from 'sweetalert2';

const spare_typeId = ref();

const form = reactive({
    image: '',
    dealer: '',
    type: '',
    brand: '',
    buy_price: '',
    sell_price: '',
    description: ''
});

//const router = useRouter()

//const route = useRoute()


const page = usePage();
const editMode = ref(false);
let errors = ref([]);

onMounted(() => {
    // Check if there's a spare_type ID to determine edit mode
    if (page.props.route && page.props.route.name === 'spare_types.edit') {
        editMode.value = true;
        spare_typeId.value = page.props.route.params.id;
        getSpareType();
    }
});

const getSpareType = async () => {
    try {
        let response = await axios.get(`/api/spare_types/${spare_typeId.value}/edit`)
            //.then((response) => {
            if (response.data.spare_type) {
                form.image = response.data.spare_type.image;
                form.dealer = response.data.spare_type.dealer;
                form.type = response.data.spare_type.type;
                form.brand = response.data.spare_type.brand;
                form.buy_price = response.data.spare_type.buy_price;
                form.sell_price = response.data.spare_type.sell_price;
                form.description = response.data.spare_type.description;
            //});
            }
            
    } catch (error) {
        console.error("Error fetching spare_type data:", error);
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
        updateSpareType(values, actions);
    } else {
        createSpareType(values, actions);
    }
};

const createSpareType = (values, actions) => {
    axios.post('/api/spare_types', form)
        .then((response) => {
            toast.fire({ icon: "success", title: "Type de pièce ajouté" });
            setTimeout(() => {
                Inertia.visit('/spare_types/index/');
            }, 2000);
        })
        .catch((error) => {
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else {
                console.error("Error creating spare_type:", error);
            }
        });
};

const updateSpareType = (values, actions) => {
    axios.put(`/api/spare_types/${spare_typeId.value}`, form)
        .then((response) => {
            toast.fire({ icon: "success", title: "Type de pièce modifié" });
            setTimeout(() => {
                Inertia.visit('/spare_types/index/');
        }, 2000);
        })
        .catch((error) => {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else {
                console.error("Error creating spare_type:", error);
            }
        });
};
</script>

<template>
    <Head title="Enregistrement Type de pièce" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                <span v-if="editMode">Modification d'un type de pièce</span>
                <span v-else>Nouvel Type de pièce</span>
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
                            <p class="mb-1">Fournisseur</p>
                            <input type="text" class="input" id="dealer" name="dealer" v-model="form.dealer">
                            <small style="color:red" v-if="errors.dealer">{{ errors.dealer }}</small>
                            <p class="mb-1">Type</p>
                            <input type="text" class="input" id="type" name="type" v-model="form.type">
                            <small style="color:red" v-if="errors.type">{{ errors.type }}</small>
                            <p class="mb-1">Marque</p>
                            <input type="text" class="input" id="brand" name="brand" v-model="form.brand">
                            <p class="my-1">Description (optional)</p>
                            <textarea cols="10" rows="5" class="textarea" id="description" name="description" v-model="form.description"></textarea>
                            <small style="color:red" v-if="errors.description">{{ errors.description }}</small>
                            <p class="mb-1">Prix achat</p>
                            <input type="text" class="input" id="buy_price" name="buy_price" v-model="form.buy_price">
                            <p class="mb-1">Prix vente</p>
                            <input type="text" class="input" id="sell_price" name="sell_price" v-model="form.sell_price">

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
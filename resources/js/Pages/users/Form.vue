<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { reactive, ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
//import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';
import toast from 'sweetalert2';

const userId = ref();

const form = reactive({
    image: '',
    name: '',
    email: '',
    phone: '',
    role: ''
});

//const router = useRouter()

//const route = useRoute()


const page = usePage();
const editMode = ref(false);
let errors = ref([]);

onMounted(() => {
    // Check if there's a user ID to determine edit mode
    if (page.props.route && page.props.route.name === 'users.edit') {
        editMode.value = true;
        userId.value = page.props.route.params.id;
        console.log("Edit Mode, User ID:", userId.value); // Debug log
        getUser();
    }
});

const getUser = async () => {
    try {
        let response = await axios.get(`/api/users/${userId.value}/edit`)
            console.log("API Response for User:", response.data); // Debug log
            //.then((response) => {
            if (response.data.user) {
                form.image = response.data.user.image;
                form.name = response.data.user.name;
                form.email = response.data.user.email;
                form.phone = response.data.user.phone;
                form.role = response.data.user.role;
            //});
            }
            
    } catch (error) {
        console.error("Error fetching user data:", error);
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
        updateUser(values, actions);
    } else {
        createUser(values, actions);
    }
};

const createUser = (values, actions) => {
    axios.post('/api/users', form)
        .then((response) => {
            toast.fire({ icon: "success", title: "utilisateur ajouté" });
            setTimeout(() => {
                Inertia.visit('/users/index/');
            }, 2000);
        })
        .catch((error) => {
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else {
                console.error("Error creating user:", error);
            }
        });
};

const updateUser = (values, actions) => {
    axios.put(`/api/users/${userId.value}`, form)
        .then((response) => {
            toast.fire({ icon: "success", title: "Type d'utilisateur modifié" });
            setTimeout(() => {
                Inertia.visit('/users/index/');
        }, 2000);
        })
        .catch((error) => {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else {
                console.error("Error creating user:", error);
            }
        });
};
</script>

<template>
    <Head title="Enregistrement d'un utilisateur" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                <span v-if="editMode">Modification d'un utilisateur</span>
                <span v-else>Nouvel Utilisateur</span>
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
                            <p class="mb-1">Nom</p>
                            <input type="text" class="input" id="name" name="name" v-model="form.name">
                            <small style="color:red" v-if="errors.name">{{ errors.name }}</small>
                            <p class="mb-1">e-mail</p>
                            <input type="text" class="input" id="email" name="email" v-model="form.email">
                            <small style="color:red" v-if="errors.email">{{ errors.email }}</small>
                            <p class="mb-1">Téléphone</p>
                            <input type="text" class="input" id="phone" name="phone" v-model="form.phone">
                            <p class="mb-1">Rôle</p>
                            <input type="text" class="input" id="role" name="role" v-model="form.role">
                            <small style="color:red" v-if="errors.role">{{ errors.role }}</small>

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
import { createRouter, createWebHistory } from 'vue-router';
import Welcome from '../Pages/Welcome.vue';
import Login from '../Pages/Auth/Login.vue';
import Register from '../Pages/Auth/Register.vue';
import Dashboard from '../Pages/Dashboard.vue';
import Dashboard_Admin from '../Pages/Dashboard_Admin.vue';
import Dashboard_Worker from '../Pages/Dashboard_Worker.vue';
import index from '../Pages/devices/Index.vue';
import deviceForm from '../Pages/devices/Form.vue';
import NotFound from '../Pages/NotFound.vue';

const routes = [
    { path: '/', component: Welcome },
    { path: '/login', component: Login },
    { path: '/register', component: Register },

    { path: '/dashboard', component: Dashboard },
    { path: '/admin/dashboard', name: 'dashboard_admin', component: Dashboard_Admin },
    { path: '/worker/dashboard', component: Dashboard_Worker },

    { path: '/devices/index', name: 'devices.index', component: index},
    { path: '/devices/create', name: 'devices.create', component: deviceForm},
    { path: '/devices/:id/edit', name: 'devices.edit', component: deviceForm},

    { path: '/:pathMatch(.*)*', name: 'not-found', component: NotFound },
]

const router = createRouter({
    history: createWebHistory(),
    routes
    })

export default router;
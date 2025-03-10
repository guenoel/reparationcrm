import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import Swal from 'sweetalert2';

// Récupération du nonce depuis le DOM
const nonceMeta = document.querySelector('meta[name="csp-nonce"]');
window.cspNonce = nonceMeta ? nonceMeta.getAttribute('content') : '';

console.log("🚀 Nonce chargé dans Vue.js:", window.cspNonce);

// Appliquer le nonce aux scripts et styles injectés dynamiquement
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("script, style").forEach(el => {
        el.setAttribute("nonce", window.cspNonce);
    });
});

window.Swal = Swal;
const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
});
window.toast = toast;

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

import axios from 'axios';

axios.defaults.withCredentials = true;
axios.defaults.headers.common['Accept'] = 'application/json';

// Récupération du nonce depuis le DOM
const nonceMeta = document.querySelector('meta[name="csp-nonce"]');
window.cspNonce = nonceMeta ? nonceMeta.getAttribute('content') : '';

console.log("🚀 CSP Nonce récupéré dans bootstrap.js:", window.cspNonce);

// Appliquer le nonce après chargement du DOM
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("script, style").forEach(el => {
        el.setAttribute("nonce", window.cspNonce);
    });
});

const csrfToken = document.cookie
    .split('; ')
    .find(row => row.startsWith('XSRF-TOKEN='))
    ?.split('=')[1];

if (csrfToken) {
    axios.defaults.headers.common['X-XSRF-TOKEN'] = decodeURIComponent(csrfToken);
} else {
    console.error('CSRF token not found in cookies.');
}

// Charger le token depuis le localStorage
const token = localStorage.getItem('Authorization');

if (token) {
    axios.defaults.headers.common['Authorization'] = token;
} else {
    console.warn('No Authorization token found in localStorage.');
}


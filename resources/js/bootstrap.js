import axios from 'axios';
window.axios = axios;

// Set default headers for Axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Extract the CSRF token from the cookie and set it as a default header
const csrfToken = document.cookie
    .split('; ')
    .find(row => row.startsWith('XSRF-TOKEN='))
    ?.split('=')[1];

if (csrfToken) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = decodeURIComponent(csrfToken);
} else {
    console.error('CSRF token not found in cookies.');
}

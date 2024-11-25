import axios from 'axios';
window.axios = axios;

// Automatically attach the CSRF token from cookies to all requests
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Attach X-XSRF-TOKEN from the cookies
const csrfToken = document.cookie
    .split('; ')
    .find(row => row.startsWith('XSRF-TOKEN='))
    ?.split('=')[1];

if (csrfToken) {
    window.axios.defaults.headers.common['X-XSRF-TOKEN'] = csrfToken;
}
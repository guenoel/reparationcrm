import axios from 'axios';

axios.defaults.withCredentials = true;
axios.defaults.headers.common['Accept'] = 'application/json';


const csrfToken = document.cookie
    .split('; ')
    .find(row => row.startsWith('XSRF-TOKEN='))
    ?.split('=')[1];

if (csrfToken) {
    axios.defaults.headers.common['X-XSRF-TOKEN'] = decodeURIComponent(csrfToken);
} else {
    console.error('CSRF token not found in cookies.');
}

// Fetch Bearer token from cookies or local storage
// const bearerToken = document.cookie
//     .split('; ')
//     .find(row => row.startsWith('Authorization='))
//     ?.split('=')[1];

// Charger le token depuis le localStorage
const token = localStorage.getItem('Authorization');

if (token) {
    axios.defaults.headers.common['Authorization'] = token;
} else {
    console.warn('No Authorization token found in localStorage.');
}


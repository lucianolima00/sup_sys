import axios from 'axios';

const api = axios.create({
    baseURL: '/api',
    withCredentials: true,
    // @ts-ignore — withXSRFToken is available in axios 1.x but not always typed
    withXSRFToken: true,
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    },
});

let redirecting = false;

api.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401 && !redirecting) {
            redirecting = true;
            window.location.href = '/login';
        }
        return Promise.reject(error);
    }
);

export default api;

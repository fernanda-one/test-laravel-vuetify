import axios from 'axios'
const api = axios.create({  
    baseURL: 'http://127.0.0.1:8000/api',
    headers: {
        'Content-Type': 'application/json',
    },
    timeout: 10000,
});

api.interceptors.request.use((config) => {
    const userData = localStorage.getItem('user') || '';
    if (userData) {
        const token = JSON.parse(userData).token
        config.headers.Authorization =  token ? `Bearer ${token}` : '';

    }
    return config;
  }, (error) => {
    return Promise.reject(error);
  });
  
export default api;

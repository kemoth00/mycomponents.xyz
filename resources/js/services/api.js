import axios from 'axios';
import store from '@/store';
import router from '@/router';

import auth from '@/services/modules/auth';
import user from '@/services/modules/user';
import components from '@/services/modules/components';

const api = axios.create({
  baseURL: import.meta.env.VITE_APP_URL,
});

api.interceptors.request.use(
  (config) => {
    if (config.headers['Content-Type'] === 'multipart/form-data') {
      config.headers['Content-Type'] = 'multipart/form-data';
    } else {
      config.headers['Content-Type'] = 'application/json';
    }

    if (store.state.auth.token) {
      config.headers['Authorization'] = 'Bearer ' + store.state.auth.token;
    }

    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

api.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {
    if (error.response.status === 401) {
      localStorage.removeItem('token');
      store.state.auth.token = null;
      store.state.auth.user = null;
      store.state.popups.login = true;
    } else if (error.response.status === 403) {
      router.push({ name: 'Home' });
    } else if (error.response.status === 404) {
      router.push({ name: '404' });
    } else if (error.response.status === 500) {
      router.push({ name: 'Home' });
    }

    return error;
  }
);

api.auth = auth;
api.user = user;
api.components = components;

export default api;

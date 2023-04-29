import api from '../api';
import store from '@/store';

export default {
  register(data) {
    return new Promise((resolve, reject) => {
      api
        .post('/api/register', data)
        .then((response) =>
          resolve(response.data ? response.data : response.response.data)
        )
        .catch((error) => reject(error));
    });
  },
  login(data) {
    return new Promise((resolve, reject) => {
      api
        .post('/api/login', data)
        .then((response) =>
          resolve(response.data ? response.data : response.response.data)
        )
        .catch((error) => reject(error));
    });
  },
  logout() {
    return new Promise((resolve, reject) => {
      api
        .post('/api/logout')
        .then((response) => resolve(response.data?.data))
        .catch((error) => reject(error));
    });
  },
  getUser() {
    return new Promise((resolve, reject) => {
      api
        .get('/api/user')
        .then((response) => resolve(response.data?.data))
        .catch((error) => reject(error));
    });
  },
};

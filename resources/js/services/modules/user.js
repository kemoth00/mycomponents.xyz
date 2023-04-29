import api from '../api';
import store from '@/store';

export default {
  getUser(data) {
    return new Promise((resolve, reject) => {
      api
        .get('/api/user', data)
        .then((response) => resolve(response.data?.data))
        .catch((error) => reject(error));
    });
  },
  postDetails(data) {
    return new Promise((resolve, reject) => {
      api
        .post('/api/user/details', data)
        .then((response) =>
          resolve(response.data ? response.data.data : response.response.data)
        )
        .catch((error) => reject(error));
    });
  },
  postUpdate(data) {
    return new Promise((resolve, reject) => {
      api
        .post('/api/user/update', data)
        .then((response) =>
          resolve(response.data ? response.data.data : response.response.data)
        )
        .catch((error) => reject(error));
    });
  },
  postPassword(data) {
    return new Promise((resolve, reject) => {
      api
        .post('/api/user/change-password', data)
        .then((response) =>
          resolve(response.data ? response.data.data : response.response.data)
        )
        .catch((error) => reject(error));
    });
  },
  getOpenings(query = '') {
    return new Promise((resolve, reject) => {
      api
        .get('/api/user/openings' + query)
        .then((response) => resolve(response.data))
        .catch((error) => reject(error));
    });
  },
  getOpeningsPublic(username, query = '') {
    return new Promise((resolve, reject) => {
      api
        .get('/api/user/' + username + '/openings' + query)
        .then((response) => resolve(response.data))
        .catch((error) => reject(error));
    });
  },
  getPublicProfile(username) {
    return new Promise((resolve, reject) => {
      api
        .get('/api/user/' + username)
        .then((response) => resolve(response.data?.data))
        .catch((error) => reject(error));
    });
  },
  postDeposit(data) {
    return new Promise((resolve, reject) => {
      api
        .post('/api/deposit', data)
        .then((response) =>
          resolve(response.data ? response.data : response.response.data)
        )
        .catch((error) => reject(error));
    });
  },
  getTransactions(query = '') {
    return new Promise((resolve, reject) => {
      api
        .get('/api/user/transactions' + query)
        .then((response) => resolve(response.data))
        .catch((error) => reject(error));
    });
  },
  postImage(data) {
    return new Promise((resolve, reject) => {
      api
        .post('/api/user/image', data, {
          headers: { 'Content-Type': 'multipart/form-data' },
        })
        .then((response) =>
          resolve(response.data ? response.data.data : response.response.data)
        )
        .catch((error) => reject(error));
    });
  },
};

import api from '../api';
import store from '@/store';

export default {
  create(data) {
    return new Promise((resolve, reject) => {
      api
        .post('/api/components', data, {
          headers: { 'Content-Type': 'multipart/form-data' },
        })
        .then((response) =>
          resolve(response.data ? response.data.data : response.response.data)
        )
        .catch((error) => reject(error));
    });
  },
  getComponent(uuid) {
    return new Promise((resolve, reject) => {
      api
        .get('/api/components/' + uuid)
        .then((response) => {
          resolve(response.data.data);
        })
        .catch((error) => reject(error));
    });
  },
  getComponents(order = 'popular', page = 1) {
    return new Promise((resolve, reject) => {
      api
        .get('/api/components/' + order + '?page=' + page)
        .then((response) => {
          resolve(response.data);
        })
        .catch((error) => reject(error));
    });
  },
  upvoteComponent(uuid) {
    return new Promise((resolve, reject) => {
      api
        .get('/api/components/upvote/' + uuid)
        .then((response) =>
          resolve(response.data ? response.data.data : response.response.data)
        )
        .catch((error) => reject(error));
    });
  },
  downvoteComponent(uuid) {
    return new Promise((resolve, reject) => {
      api
        .get('/api/components/downvote/' + uuid)
        .then((response) =>
          resolve(response.data ? response.data.data : response.response.data)
        )
        .catch((error) => reject(error));
    });
  },
  searchComponents(data, page = 1) {
    return new Promise((resolve, reject) => {
      api
        .post('/api/components/search?page=' + page, data)
        .then((response) => {
          resolve(response.data);
        })
        .catch((error) => reject(error));
    });
  },
};

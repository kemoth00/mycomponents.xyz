import store from '@/store';
import router from '@/router';

export default {
  getAppUrl() {
    return import.meta.env.VITE_STORAGE_URL;
  },
  fieldOnChange(e, field, form, formErrors) {
    form[field] = e;

    if (formErrors && formErrors.hasOwnProperty(field)) {
      delete formErrors[field];
    }
  },
  kFormatter(num) {
    return Math.abs(num) > 999
      ? Math.sign(num) * (Math.abs(num) / 1000).toFixed(1) + 'k'
      : Math.sign(num) * Math.abs(num);
  },
  dateTimeFormatter(date) {
    return new Date(date).toLocaleString('en-US', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: 'numeric',
      minute: 'numeric',
      second: 'numeric',
    });
  },
};

import Vue from 'vue';
import App from '@/App';
import router from '@/router';
import store from '@/store';
import { install as api, default as apiClient } from '@/api';

Vue.use(api, { store, router });

new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});

import axios from 'axios'

const client = axios.create({
    baseURL: '/api/'
});

export const install = (Vue, { store, router }) => {
    Object.defineProperty(Vue.prototype, '$http', {
        get () { return client }
    });

    client.defaults.timeout = 45000;
};

export default client;

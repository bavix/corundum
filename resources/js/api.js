
const axios = require('axios');

const api = {

    async route(name) {
        return axios.get('/api/route')
            .then(res => '/' + res.data[name])
    },

    async get(name, data) {
        return axios.get(await this.route(name), data);
    },

    async post(name, data) {
        return axios.post(await this.route(name), data);
    },

    async delete(name) {
        return axios.delete(await this.route(name));
    },

};

export default api;

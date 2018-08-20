
const axios = require('axios');
let routes;

const api = {

    async route(name) {
        if (routes === undefined) {
            return axios.get('/api/route')
                .then(res => {
                    routes = res.data;
                    return this.route(name);
                })
        }

        return Promise.resolve('/' + routes[name]);
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

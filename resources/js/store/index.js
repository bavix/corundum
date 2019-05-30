
import Vue from 'vue'
import Vuex from 'vuex'

import bucket from './bucket'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        bucket
    },
    strict: process.env.NODE_ENV !== 'production'
});

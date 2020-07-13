import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex);

import tasks from './modules/tasks';

/*const debug = process.env.NODE_ENV !== 'production';*/

export default new Vuex.Store({
    modules: {
        tasks
    },
    /*strict: debug,*/
})

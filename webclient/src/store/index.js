import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);
import axios from 'axios';
import router from "../router";

import state from './state';
import actions from './actions';
import getters from './getters';
import mutations from './mutations';

export default new Vuex.Store({
    state,
    getters,
    mutations,
    actions,
    modules: {}
});

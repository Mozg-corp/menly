import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import './assets/css/styles.css';

import './icons.js';

Vue.config.productionTip = true;

const token = localStorage.getItem('user-token');

if (token) {

    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

}
store.state.admin = localStorage.getItem('user-isAdmin') === "true"? true : false;
store.state.username = localStorage.getItem('user-username');
store.state.token = localStorage.getItem('user-token');
store.state.userId= localStorage.getItem('user-id');
//console.log(store.state)
axios.defaults.headers.common['Content-Type'] = 'Application/json';

// Install BootstrapVue
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);


new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app');


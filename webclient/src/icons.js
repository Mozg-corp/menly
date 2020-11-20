import Vue from 'vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faBars, faSignOutAlt } from "@fortawesome/free-solid-svg-icons";
library.add(faBars, faSignOutAlt);

Vue.component('fa-icon', FontAwesomeIcon);

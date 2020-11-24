import Vue from 'vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faBars, faSignOutAlt, faAngleDoubleUp} from "@fortawesome/free-solid-svg-icons";
import { faTelegram } from "@fortawesome/free-brands-svg-icons";
library.add(faBars, faSignOutAlt, faTelegram, faAngleDoubleUp);

Vue.component('fa-icon', FontAwesomeIcon);

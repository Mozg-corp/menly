import Vue from 'vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faBars, faSignOutAlt, faAngleDoubleUp, faChevronCircleDown, faChevronCircleUp} from "@fortawesome/free-solid-svg-icons";
import { faTelegram } from "@fortawesome/free-brands-svg-icons";
// import { faCaretSquareUp } from "@fortawesome/free-regular-svg-icons";
library.add(faBars, faSignOutAlt, faTelegram, faAngleDoubleUp, faChevronCircleDown, faChevronCircleUp);

Vue.component('fa-icon', FontAwesomeIcon);

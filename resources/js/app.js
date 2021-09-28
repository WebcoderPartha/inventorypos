
require('./bootstrap');


// VUE IMPORT
import  Vue from 'vue'

// VUE ROUTER IMPORT AREA
import VueRouter from "vue-router";
Vue.use(VueRouter);

// GLOBAL COMPONENT IMPORT AREA

import Topbar from "./components/Navbar/Topbar";
import Sidebar from "./components/Navbar/Sidebar";

// END GLOBAL COMPONENT AREA

// ROUTES IMPORT AREA
import {routes} from './routes/routes';

// NOTY - NOTIFICATION IMPORT AREA
import Notification from "./helpers/Notification";
window.Notification = Notification;

// SWEET ALERT IMPORT AREA
import Swal from "sweetalert2";
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
window.Toast = Toast;
// END SWEET ALERT AREA

// Reload
window.Reload = new Vue();

// AUTHENTICATE USER CLASS IMPORT AREA
import User from './helpers/User';
window.User = User


// VUE ROUTER DEFINE AREA
const router = new VueRouter({
    routes,
    mode: 'history'
})



const app = new Vue({
    el: '#app',
    router,
    components: {
        Topbar,
        Sidebar
    }

});

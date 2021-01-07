import './bootstrap';

window.Vue = require('vue');
import VueToastr from 'vue-toastr';
//Vue.use(VueToastr);
Vue.use(VueToastr, {
    defaultPosition: 'toast-top-center',
    defaultType: 'info',
    defaultTimeout: 3000
});

window.VueAxios = require('vue-axios').default;
window.Axios = require('axios').default;
import BootstrapVue from 'bootstrap-vue'; //Importing
Vue.use(BootstrapVue); // Telling Vue to use this in whole application
import  stock from './components/CreateStock';

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('gestion-comande', require('./components/Gestion-Comande.vue').default);
Vue.component('create-client', require('./components/Create-Client.vue').default);
Vue.component('stock', require('./components/CreateStock.vue').default);
Vue.component('createvente', require('./components/CreateVente.vue').default);
Vue.component('commande', require('./components/Commande.vue').default);

const app = new Vue({
    el: '#app',
});
window.Jquery = require('jquery');

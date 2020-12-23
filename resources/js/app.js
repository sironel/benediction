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
import  stock from './components/CreateStock';

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('gestion-comande', require('./components/Gestion-Comande.vue').default);
Vue.component('create-client', require('./components/Create-Client.vue').default);
Vue.component('stock', require('./components/CreateStock.vue').default);

const app = new Vue({
    el: '#app',
});
window.Jquery = require('jquery');

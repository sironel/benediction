import './bootstrap';

window.Vue = require('vue');
window.VueAxios = require('vue-axios').default;
window.Axios = require('axios').default;
// import  createcomp from './components/Create-Client';

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('gestion-comande', require('./components/Gestion-Comande.vue').default);
Vue.component('create-client', require('./components/Create-Client.vue').default);

const app = new Vue({
    el: '#app',
});
window.Jquery = require('jquery');

require('./bootstrap');
require('./extenders');

// load packages
window.Vue = require('vue');
window.axios = require('axios');
window._ = require('lodash');
window.Event = new Vue();

Vue.use(require('vue2-filters'));
Vue.use(require('vue-moment'));
Vue.use(require('buefy'));
Vue.use(require('vue-google-api').default, require('./GapiConfig').GapiConfig);

Vue.config.productionTip = false;

// load components
const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('pagination', require('laravel-vue-bulma-paginator'));

// app
const app = new Vue({
    el: '#app'
});

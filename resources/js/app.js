import Vue from 'vue'
import store from './store'
import axios from 'axios'
import NProgress from "nprogress";
import 'nprogress/nprogress.css';
import Echo from 'laravel-echo'

import router from './routes.js'
Vue.router = router;

import Vuelidate from 'vuelidate'
Vue.use(Vuelidate);

import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue);

import VueAxios from 'vue-axios'
Vue.use(VueAxios, axios);
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api/`;

import VueAuth from "@websanova/vue-auth";
import auth from './auth'
Vue.use(VueAuth, auth);

import VueI18n from 'vue-i18n'
Vue.use(VueI18n);

//Import Scss
import "../sass/themes.scss";

// Load All Locale Files
let loadLocaleFiles = function(req) {
    const lang = {};
    req.keys().forEach(filename => {
        let split = filename.split('.')[1].split('/');
        let name = split[1];
        let page = split[2];
        if(!lang.hasOwnProperty(name))
            lang[name] = {};
        lang[name][page] = req(filename).default;
    });
    return lang;
};

let language = loadLocaleFiles(require.context('./locales/', true, /\.js$/));

export const messages = {
    en: language.en,
    tr: language.tr,
};

export const i18n = new VueI18n({
    locale: 'tr',
    fallbackLocale: 'tr',
    messages
});


Vue.axios.interceptors.request.use(config => {
    NProgress.start();
    return config;
}, (error) => {
    NProgress.done();
    return Promise.reject(error);
});

Vue.axios.interceptors.response.use(function (response) {
    NProgress.done();
    return response;
}, function (error) {
    NProgress.done();
    if (error.response.status === 401 || error.response.status === 403) {
        Vue.auth.logout({
            redirect: 'login',
            makeRequest: false,
        });
        return true;
    }
    return Promise.reject(error);
});

import App from './layouts/App.vue'

Vue.config.productionTip = false;

Vue.config.devtools = process.env.NODE_ENV === 'development';

window.io = require('socket.io-client')

export var echo_instance = new Echo({
    broadcaster: "socket.io",
    host: '127.0.0.1:6001',
})

Vue.prototype.$echo = echo_instance;

const app = new Vue({
    el: '#app',
    router,
    store,
    i18n,
    render: h => h(App)
});

export default app;

import { createApp } from 'vue/dist/vue.esm-bundler.js';
import BlackList from './page-components/blacklist.js';
require('./bootstrap');

const BLACKLIST = '/blacklist';

let App = {};
switch (location.pathname) {
  case BLACKLIST:
    App = BlackList;
    break;
}

App.template = document.getElementById('app').innerHTML;
const app = createApp(App);

app.mount('#app');




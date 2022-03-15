require('./bootstrap')

import { createApp } from 'vue'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import App from './App.vue'
import router from './router'
import moment from 'moment'
import customAxios from "./modules/customAxios";

const app = createApp(App)

app.use(ElementPlus)
app.use(router)

app.config.globalProperties.$axios = customAxios

import DefaultLayout from '@/layout/DefaultLayout'
app.component('default-layout', DefaultLayout)

const components = require.context('./components', true, /\.vue$/i)
components.keys().map(key => app.component(key.split('/').pop().split('.')[0], files(key).default))

app.mount('#app')


//import HelloWorld from './components/Welcome'

//app.component('hello-world', HelloWorld)


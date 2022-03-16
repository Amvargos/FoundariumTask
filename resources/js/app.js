require('./bootstrap')

import { createApp } from 'vue'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import locale from 'element-plus/lib/locale/lang/ru'
import App from './App.vue'
import router from './router'
import moment from 'moment'
import Notifications from '@kyvg/vue3-notification'
import customAxios from "./modules/customAxios";


const app = createApp(App)


app.use(ElementPlus, { locale })
app.use(router)
app.use(Notifications)

app.config.globalProperties.$axios = customAxios

import DefaultLayout from '@/layout/DefaultLayout'
app.component('default-layout', DefaultLayout)

app.directive('isAdmin', (el, binding) => {
    if(localStorage.getItem('role') !== 'admin') {
        el.remove();
    }
})
app.config.globalProperties.$filters = {
    formatDateDMT(value) {
        if (value) {
            return moment(String(value)).locale("ru").format('DD MMMM YYYY HH:mm')
        }
    },
    formatDateFromNow(){
        if (value) {
            return moment(String(value)).locale("ru").fromNow();
        }
    },
    formatDateTimeHI(){
        if (value) {
            return moment(String(value)).locale("ru").format('DD-MM-YYYY HH:m:s')
        }
    }
}


const components = require.context('./components', true, /\.vue$/i)
components.keys().map(key => app.component(key.split('/').pop().split('.')[0], files(key).default))

app.mount('#app')


//import HelloWorld from './components/Welcome'

//app.component('hello-world', HelloWorld)


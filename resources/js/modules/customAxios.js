import axios from "axios";
import { notify } from "@kyvg/vue3-notification";

const instance = axios.create({
    baseURL: '/api/',
    timeout: 60000,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': 'Bearer '+localStorage.getItem("token", this)
    },
});


const notifyError = (error) => {
    let errors = error.response.data.error || error.response.data.errors;
    if(!errors){
        let errors = error.response.data?.message
    }
    if (typeof errors === 'string') {
        errors = [errors];
    }
    if (errors) {
        Object.keys(errors).forEach((key) => {
            if (key === "0") {
                notify({
                    title: 'Ошибка',
                    text: errors[0],
                    type: 'error',
                });
            } else {
                notify({
                    title: 'Ошибка',
                    text: errors[key][0],
                    type: 'error',
                });
            }
        });
    }
}

instance.interceptors.response.use(
    response => response,
    (error) => {
        let path = location.pathname;
        if (error.response.status === 401) {
            if(path !== '/login' && path !== '/register') {
                location.href = '/login';
            }else{
                notifyError(error);
            }
        } else {
            notifyError(error);
        }

        return Promise.reject(error);
    },
);
export default instance;

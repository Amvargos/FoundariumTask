import axios from "axios";

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
                // Vue.prototype.$notify({
                //     group: 'foo',
                //     title: 'Ошибка',
                //     type: 'error',
                //     text: errors[0],
                //     duration: 7000
                // });
            } else {
                // Vue.prototype.$notify({
                //     group: 'foo',
                //     title: 'Ошибка',
                //     type: 'error',
                //     text: errors[key][0],
                //     duration: 7000
                // });
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

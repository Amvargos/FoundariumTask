<template>
    <div>
        <el-form
            class="login-form"
            :model="form"
            ref="form"
            @submit.native.prevent="login"
        >
            <el-form-item>
                <el-input size="large" v-model="form.email" placeholder="E-Mail"></el-input>
            </el-form-item>
            <el-form-item>
                <el-input size="large" v-model="form.password" placeholder="Пароль"></el-input>
            </el-form-item>
            <el-button
                :loading="loading"
                class="login-button"
                native-type="submit"
                block
            >Войти
            </el-button>
            <el-button
                type="text"
                @click="$router.push('/register')"
                class="login-button"
            >

                    Я не зарегистрирован

            </el-button>
        </el-form>
    </div>
</template>

<script>
export default {
    name: "LoginScreen",
    data() {
        return {
            loading: false,
            form: {
                email: '',
                password: ''
            }
        };
    },
    methods: {
        login(){
            this.loading = true;
            this.$axios.post(`/login`, this.form)
                .then((response) => {
                    localStorage.setItem("token", response.data.token);
                    localStorage.setItem("role", response.data.user.roles[0].name);
                    this.$axios.defaults.headers.common['Authorization'] = 'Bearer '+localStorage.getItem("token", this);
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    }
}
</script>

<style scoped>

</style>

<template>
    <div>
        <el-form
            class="login-form"
            :model="form"
            ref="form"
            @submit.native.prevent="register"
        >
            <el-form-item>
                <el-input size="large" v-model="form.name" placeholder="Имя"></el-input>
            </el-form-item>
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
            >Зарегистрироваться
            </el-button>
            <el-button
                type="text"
                @click="$router.push('/login')"
                class="login-button"
            >

                Я уже зарегистрирован

            </el-button>
        </el-form>
    </div>
</template>

<script>
export default {
    name: "RegisterScreen",
    data() {
        return {
            loading: false,
            form: {
                name: '',
                email: '',
                password: ''
            }
        };
    },
    methods: {
        register(){
            this.$axios.post(`/register`, this.form)
                .then((response) => {

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

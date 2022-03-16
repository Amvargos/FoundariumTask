<template>
    <component is="default-layout">
        <router-view v-slot="{ Component }">
            <transition  name="opacity" mode="out-in">
                <component :is="Component" />
            </transition>
        </router-view>
    </component>
</template>

<script>
export default {
    created() {
        this.getUser();
    },
    methods: {
        getUser(){
            this.$axios.get('/getUser').then((response) => {
                localStorage.setItem("role", response.data.roles[0].name);
            });
        }
    },
}
</script>

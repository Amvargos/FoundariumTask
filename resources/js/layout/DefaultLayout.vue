<template>
    <div class="common-layout">
        <notifications position="bottom left" />
        <el-container>
            <el-header>
                <el-menu
                    default-active="/"
                    class="el-menu-demo"
                    mode="horizontal"
                    :router="true"
                >
                    <el-menu-item index="/">Главная</el-menu-item>
                    <el-menu-item index="/autos" v-isAdmin>Автомобили</el-menu-item>
                    <el-menu-item index="/users" v-isAdmin>Пользователи</el-menu-item>
                </el-menu>
            </el-header>
            <el-main><slot /></el-main>
        </el-container>
    </div>
</template>
<script>
export default {
    name: "DefaultLayout"
}
</script>

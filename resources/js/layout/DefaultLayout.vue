<template>
    <div class="common-layout">
        <el-container>
            <el-header>
                <el-menu
                    :default-active="activeIndex"
                    class="el-menu-demo"
                    mode="horizontal"
                    @select="handleSelect"
                >
                    <el-menu-item index="1">Главная</el-menu-item>
                    <el-menu-item index="3">Автомобили</el-menu-item>
                    <el-menu-item index="4">Пользователи</el-menu-item>
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

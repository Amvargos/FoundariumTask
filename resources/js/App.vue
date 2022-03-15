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

}
</script>

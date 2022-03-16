import { createWebHistory, createRouter } from "vue-router";
import MainScreen from "@/screens/MainScreen";
import LoginScreen from "@/screens/auth/LoginScreen";
import RegisterScreen from "@/screens/auth/RegisterScreen";
import AutosScreen from "@/screens/auto/MainScreen";

export const routes = [
    {
        name: 'main',
        path: '/',
        component: MainScreen,
    },

    {
        name: 'autos',
        path: '/autos',
        component: AutosScreen,
    },

    {
        name: 'login',
        path: '/login',
        component: LoginScreen,
    },

    {
        name: 'register',
        path: '/register',
        component: RegisterScreen,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;

import { createWebHistory, createRouter } from "vue-router";
import MainScreen from "@/screens/MainScreen";

const routes = [
    {
        path: "/",
        name: "Main",
        component: MainScreen,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;

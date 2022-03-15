import MainScreen from "./screens/MainScreen";

export const routes = [
    {
        name: 'main',
        path: '/',
        component: MainScreen,
        meta: {
            permissions: [
                {role: "guest", access: false, redirect: "login"}
            ],
        }
    },
];

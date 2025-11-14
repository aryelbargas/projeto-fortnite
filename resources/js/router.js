import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        component: () => import("./views/Home.vue"),
    },
    {
        path: "/entrar",
        component: () => import("./views/Login.vue"),
    },
    {
        path: "/cadastrar",
        component: () => import("./views/Register.vue"),
    },
    {
        path: "/profile",
        component: () => import("./views/Profile.vue"),
    },
    {
        path: "/ballance",
        component: () => import("./views/Ballance.vue"),
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
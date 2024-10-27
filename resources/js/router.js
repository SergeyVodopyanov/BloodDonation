import { createRouter, createWebHistory } from "vue-router";
const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            redirect: { name: "point.index" },
        },
        {
            path: "/points",
            component: () => import("./components/Point/Index.vue"),
            name: "point.index",
        },
        {
            path: "/points/:id",
            component: () => import("./components/Point/Show.vue"),
            name: "point.show",
        },
        {
            path: "/points/import",
            component: () => import("./components/Point/Import.vue"),
            name: "point.import",
        },
        {
            path: "/users/login",
            component: () => import("./components/User/Login.vue"),
            name: "user.login",
        },
        {
            path: "/users/registration",
            component: () => import("./components/User/Registration.vue"),
            name: "user.registration",
        },
        {
            path: "/users/personal",
            component: () => import("./components/User/Personal.vue"),
            name: "user.personal",
        },
        {
            //Если в адресную строку вбита ерунда по типу "/users/personal321312312314fscs"
            path: "/:catchAll(.*)",
            component: () => import("./components/NotFound.vue"),
            name: "404",
        },
    ],
});
router.beforeEach((to, from, next) => {
    const accessToken = localStorage.getItem("access_token");
    const publicRoutes = [
        "point.index",
        "point.show",
        "fruit.index",
        "user.login",
        "user.registration",
    ];

    if (!accessToken && !publicRoutes.includes(to.name)) {
        return next({ name: "user.login" });
    }

    if (
        accessToken &&
        (to.name === "user.login" || to.name === "user.registration")
    ) {
        // return next({ name: "personal.index" });
        return next({ name: "point.index" });
    }

    next();
});
export default router;

import { createRouter, createWebHistory } from "vue-router";
const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            redirect: { name: "station.index" },
        },
        {
            path: "/stations",
            component: () =>
                import("./components/BloodDonationStations/Index.vue"),
            name: "station.index",
        },
        {
            path: "/stations/:id",
            component: () =>
                import("./components/BloodDonationStations/Show.vue"),
            name: "station.show",
        },
        {
            path: "/fruits",
            component: () => import("./components/Fruit/Index.vue"),
            name: "fruit.index",
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
        "station.index",
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
        return next({ name: "personal.index" });
    }

    next();
});
export default router;

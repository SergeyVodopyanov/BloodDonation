import { createRouter, createWebHistory } from "vue-router";
const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            redirect: { name: "user.login" }, // Перенаправление на user.login
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
    //Если у пользователя нет токена и он пытается перейти на закрытый роут (не логин или регистрация), то его перекидывает на логин
    if (!accessToken) {
        if (
            (to.name === "user.login" && !accessToken) ||
            (to.name === "user.registration" && !accessToken)
        ) {
            return next();
        } else {
            return next({ name: "user.login" });
        }
    }
    //Если у пользователя есть токен и он пытается перейти на роут логина, то его перекидывает на личную страницу
    if (
        (to.name === "user.login" || to.name === "user.registration") &&
        accessToken
    ) {
        return next({ name: "user.personal" });
    }
    next();
});
export default router;

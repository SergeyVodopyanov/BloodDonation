<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <div class="ms-auto me-auto">
                    <router-link
                        :to="{ name: 'station.index' }"
                        class="navbar-brand"
                        >Пункты сдачи крови</router-link
                    >
                </div>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav"
                    aria-controls="navbarNav"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item" v-if="accessToken">
                            <router-link
                                :to="{ name: 'fruit.index' }"
                                class="nav-link"
                                >Fruits</router-link
                            >
                        </li>
                        <li class="nav-item" v-if="!accessToken">
                            <router-link
                                :to="{ name: 'user.login' }"
                                class="nav-link"
                                >Авторизация</router-link
                            >
                        </li>
                        <li class="nav-item" v-if="!accessToken">
                            <router-link
                                :to="{ name: 'user.registration' }"
                                class="nav-link"
                                >Регистрация</router-link
                            >
                        </li>
                        <li class="nav-item" v-if="accessToken">
                            <router-link
                                :to="{ name: 'user.personal' }"
                                class="nav-link"
                                >Personal</router-link
                            >
                        </li>
                        <li class="nav-item" v-if="accessToken">
                            <a href="#" class="nav-link" @click.prevent="logout"
                                >Выход</a
                            >
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <router-view></router-view>
    </div>
</template>

<script setup>
import { ref, watch, onMounted, computed } from "vue";
import api from "../api";
import router from "../router";
import { useAuthStore } from "../stores/auth";

const authStore = useAuthStore();

// let accessToken = ref(null);

const accessToken = computed(() => authStore.accessToken);
const user = computed(() => authStore.user);

if (accessToken.value) {
    authStore.fetchUser();
}
// onMounted(() => {
//     getAccessToken();
// });

// Следим за изменениями токена
watch(accessToken, (newVal) => {
    const token = localStorage.getItem("access_token");
    accessToken.value = token;
    // console.log("Updated access token:", token);
});

// function logout() {
//     api.post("/api/auth/logout").then(() => {
//         localStorage.removeItem("access_token");
//         accessToken.value = null;
//     });
// }

function logout() {
    api.post("/api/auth/logout").then(() => {
        authStore.logout();
        router.push({ name: "user.login" });
    });
}

// function getAccessToken() {
//     accessToken.value = localStorage.getItem("access_token");
// }
</script>

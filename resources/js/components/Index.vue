<template>
    <div>
        <router-link :to="{ name: 'station.index' }"
            >Пункты сдачи крови</router-link
        >
        <router-link :to="{ name: 'fruit.index' }">Fruits</router-link>
        <router-link v-if="!accessToken" :to="{ name: 'user.login' }"
            >Login</router-link
        >
        <router-link v-if="!accessToken" :to="{ name: 'user.registration' }"
            >Registration</router-link
        >
        <router-link v-if="accessToken" :to="{ name: 'user.personal' }"
            >Personal</router-link
        >
        <a v-if="accessToken" href="#" @click.prevent="logout">Logout</a>

        <p>Access Token: {{ accessToken }}</p>

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

// onMounted(() => {
//     getAccessToken();
// });

// Следим за изменениями токена
watch(accessToken, (newVal) => {
    const token = localStorage.getItem("access_token");
    accessToken.value = token;
    console.log("Updated access token:", token);
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

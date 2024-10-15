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
import { ref, watch, onMounted } from "vue";
import api from "../api";
import router from "../router";

let accessToken = ref(null);

onMounted(() => {
    getAccessToken();
});

// Следим за изменениями токена
watch(accessToken, (newVal) => {
    const token = localStorage.getItem("access_token");
    accessToken.value = token;
    console.log("Updated access token:", token);
});

function logout() {
    api.post("/api/auth/logout").then(() => {
        localStorage.removeItem("access_token");
        accessToken.value = null;
    });
}

function getAccessToken() {
    accessToken.value = localStorage.getItem("access_token");
}
</script>

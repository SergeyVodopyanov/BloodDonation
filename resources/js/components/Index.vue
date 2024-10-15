<template>
    <div>
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
        <router-view></router-view>
    </div>
</template>

<script setup>
import { ref, onUpdated, onMounted } from "vue";
import api from "../api";
import router from "../router";

let accessToken = ref(null);
onMounted(() => {
    getAccessToken();
});
onUpdated(() => {
    getAccessToken();
});

function logout() {
    //Если использовать просто axios, то надо прокидывать с localStorageокен, а в api он уже прокидывается
    api.post("/api/auth/logout").then((res) => {
        localStorage.removeItem("access_token");
        router.push({ name: "user.login" });
    });
}

function getAccessToken() {
    accessToken.value = localStorage.getItem("access_token");
}
</script>

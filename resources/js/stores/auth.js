import { defineStore } from "pinia";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        accessToken: localStorage.getItem("access_token") || null,
    }),
    actions: {
        setAccessToken(token) {
            this.accessToken = token;
            localStorage.setItem("access_token", token);
        },
        clearAccessToken() {
            this.accessToken = null;
            localStorage.removeItem("access_token");
        },
        login(token) {
            this.setAccessToken(token);
        },
        logout() {
            this.clearAccessToken();
        },
    },
});

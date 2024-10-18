import { defineStore } from "pinia";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        accessToken: localStorage.getItem("access_token") || null,
        user: null,
    }),
    actions: {
        setAccessToken(token) {
            this.accessToken = token;
            localStorage.setItem("access_token", token);
        },
        clearAccessToken() {
            this.accessToken = null;
            this.user = null;
            localStorage.removeItem("access_token");
        },
        login(token) {
            this.setAccessToken(token);
            this.fetchUser();
        },
        logout() {
            this.clearAccessToken();
        },
        async fetchUser() {
            try {
                const response = await axios.get("/api/auth/user", {
                    headers: {
                        Authorization: `Bearer ${this.accessToken}`,
                    },
                });
                this.user = response.data; // Сохраняем информацию о пользователе
                // console.log(this.user);
            } catch (error) {
                console.error("Failed to fetch user:", error);
            }
        },
    },
});

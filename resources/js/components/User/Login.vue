<template>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="w-25">
            <input
                v-model="email"
                type="email"
                class="form-control mt-3 mb-3"
                placeholder="Email"
            />
            <div v-if="errorLoaded && Error && Error.email" class="text-danger">
                {{ Error.email[0] }}
            </div>

            <input
                v-model="password"
                type="password"
                class="form-control mb-3"
                placeholder="Password"
            />
            <div
                v-if="errorLoaded && Error && Error.password"
                class="text-danger"
            >
                {{ Error.password[0] }}
            </div>
            <input
                @click.prevent="login"
                type="submit"
                class="btn btn-primary"
                value="Войти"
            />
        </div>
    </div>
    <div
        v-if="errorLoaded && Error && Error.general"
        class="text-danger text-center"
    >
        {{ Error.value.general[0] }}
    </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import router from "../../router";
import { useAuthStore } from "../../stores/auth";

const authStore = useAuthStore();

let email = ref("");
let password = ref("");
let Error = ref({});
let errorLoaded = ref(false);

function login() {
    axios
        .post("/api/auth/login", {
            email: email.value,
            password: password.value,
        })
        .then(function (res) {
            authStore.login(res.data.access_token);
            router.push({ name: "point.index" });
        })
        .catch((error) => {
            errorLoaded.value = true;
            if (
                error.response &&
                error.response.data &&
                error.response.data.errors
            ) {
                Error.value = { ...error.response.data.errors };
            } else {
                Error.value = { general: ["An unknown error occurred."] };
            }
            console.log(error);
            console.log(Error.value);
        });
}
</script>

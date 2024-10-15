<template>
    <div class="w-25">
        <input
            v-model="email"
            type="email"
            class="form-control mt-3 mb-3"
            placeholder="Email"
        />
        <input
            v-model="password"
            type="password"
            class="form-control mb-3"
            placeholder="Password"
        />
        <input
            @click.prevent="login"
            type="submit"
            class="btn btn-primary"
            placeholder="Войти"
        />
    </div>
    <div v-if="Error" class="text-danger">{{ Error }}</div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import router from "../../router";
let email = ref("");
let password = ref("");
let Error = ref(null);
function login() {
    axios
        .post("/api/auth/login", {
            email: email.value,
            password: password.value,
        })
        .then(function (res) {
            localStorage.setItem("access_token", res.data.access_token);
            // console.log(res.data.access_token);
            // const data = {
            //     name: "blabla",
            //     token: res.data.access_token,
            // };
            // localStorage.setItem("some_data", JSON.stringify(data));
            router.push({ name: "user.personal" });
        })
        .catch((error) => {
            if (
                error.response &&
                error.response.data &&
                error.response.data.error
            ) {
                Error.value = error.response.data.error;
            } else {
                Error.value = "An unknown error occurred.";
            }
            console.log(Error.value);
        });
}
</script>

<template>
    <div class="w-25">
        <input
            v-model="name"
            type="text"
            class="form-control bt-3 mb-3"
            placeholder="Name"
        />
        <input
            v-model="email"
            type="email"
            class="form-control mb-3"
            placeholder="Email"
        />
        <input
            v-model="password"
            type="password"
            class="form-control mb-3"
            placeholder="Password"
        />
        <input
            v-model="password_confirmation"
            type="password"
            class="form-control mb-3"
            placeholder="Confirm Password"
        />
        <input
            @click.prevent="store"
            type="submit"
            class="btn btn-primary"
            placeholder="Войти"
        />
        <div v-if="Error" class="text-danger">{{ Error }}</div>
    </div>
</template>
<script setup>
import { ref } from "vue";
import axios from "axios";
import router from "../../router";

let name = ref(null);
let email = ref(null);
let password = ref(null);
let password_confirmation = ref(null);
let Error = ref(null);

function store() {
    axios
        .post("/api/users", {
            name: name.value,
            email: email.value,
            password: password.value,
            password_confirmation: password_confirmation.value,
        })
        .then(function (res) {
            // console.log(res);
            localStorage.setItem("access_token", res.data.access_token);
            // getAccessToken();
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

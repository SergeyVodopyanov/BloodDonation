<template>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="w-25">
            <input
                v-model="last_name"
                type="text"
                class="form-control bt-3 mb-3"
                placeholder="Фамилия"
            />
            <input
                v-model="first_name"
                type="text"
                class="form-control bt-3 mb-3"
                placeholder="Имя"
            />
            <input
                v-model="middle_name"
                type="text"
                class="form-control bt-3 mb-3"
                placeholder="Отчество"
            />
            <input
                v-model="passport_series"
                type="text"
                class="form-control mb-3"
                placeholder="Серия паспорта"
            />
            <input
                v-model="passport_number"
                type="text"
                class="form-control mb-3"
                placeholder="Номер паспорта"
            />
            <input
                v-model="city"
                type="text"
                class="form-control mb-3"
                placeholder="Город"
            />
            <select
                v-model="blood_group"
                class="form-control mb-3"
                placeholder="Группа крови"
            >
                <option value="" disabled>Выберите группу крови</option>
                <option value="Первая группа крови">Первая группа крови</option>
                <option value="Вторая группа крови">Вторая группа крови</option>
                <option value="Третья группа крови">Третья группа крови</option>
                <option value="Четвёртая группа крови">
                    Четвёртая группа крови
                </option>
            </select>
            <input
                v-model="email"
                type="email"
                class="form-control mb-3"
                placeholder="Электронная почта"
            />
            <input
                v-model="password"
                type="password"
                class="form-control mb-3"
                placeholder="Пароль"
            />
            <input
                v-model="password_confirmation"
                type="password"
                class="form-control mb-3"
                placeholder="Подтвердите пароль"
            />
            <input
                @click.prevent="store"
                type="submit"
                class="btn btn-primary"
                placeholder="Войти"
            />
            <div v-if="Error" class="text-danger">{{ Error }}</div>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import router from "../../router";
import { useAuthStore } from "../../stores/auth";

const authStore = useAuthStore();

//
let last_name = ref(null);
let first_name = ref(null);
let middle_name = ref(null);
let passport_series = ref(null);
let passport_number = ref(null);
let email = ref(null);
let password = ref(null);
let password_confirmation = ref(null);
let city = ref(null);
let blood_group = ref(null);

let Error = ref(null);

function store() {
    console.log(email.value);
    console.log(password.value);
    console.log(password_confirmation.value);
    console.log(last_name.value);
    console.log(first_name.value);
    console.log(middle_name.value);
    console.log(passport_series.value);
    console.log(passport_number.value);
    console.log(city.value);
    console.log(blood_group.value);
    axios
        .post("/api/users", {
            email: email.value,
            password: password.value,
            password_confirmation: password_confirmation.value,
            last_name: last_name.value,
            first_name: first_name.value,
            middle_name: middle_name.value,
            passport_series: passport_series.value,
            passport_number: passport_number.value,
            city: city.value,
            blood_group: blood_group.value,
        })
        .then(function (res) {
            // localStorage.setItem("access_token", res.data.access_token);
            // router.push({ name: "user.personal" });
            authStore.login(res.data.access_token);
            router.push({ name: "user.personal" });
            console.log(email.value);
            console.log(password.value);
            console.log(password_confirmation.value);
            console.log(last_name.value);
            console.log(first_name.value);
            console.log(middle_name.value);
            console.log(passport_series.value);
            console.log(passport_number.value);
            console.log(city.value);
            console.log(blood_group.value);
        })
        .catch((error) => {
            if (
                error.response &&
                error.response.data &&
                error.response.data.error
            ) {
                Error.value = error.response.data.error;
            } else {
                console.log(error);
                Error.value = "An unknown error occurred.";
            }
            console.log(Error.value);
        });
}
</script>

<template>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="w-25">
            <input
                v-model="last_name"
                type="text"
                class="form-control bt-3 mb-3"
                placeholder="Фамилия"
            />
            <div v-if="errorLoaded && errors.last_name" class="text-danger">
                {{ errors.last_name[0] }}
            </div>

            <input
                v-model="first_name"
                type="text"
                class="form-control bt-3 mb-3"
                placeholder="Имя"
            />
            <div v-if="errorLoaded && errors.first_name" class="text-danger">
                {{ errors.first_name[0] }}
            </div>

            <input
                v-model="middle_name"
                type="text"
                class="form-control bt-3 mb-3"
                placeholder="Отчество"
            />
            <div v-if="errorLoaded && errors.middle_name" class="text-danger">
                {{ errors.middle_name[0] }}
            </div>

            <input
                v-model="passport_series"
                type="text"
                class="form-control mb-3"
                placeholder="Серия паспорта"
            />
            <div
                v-if="errorLoaded && errors.passport_series"
                class="text-danger"
            >
                {{ errors.passport_series[0] }}
            </div>

            <input
                v-model="passport_number"
                type="text"
                class="form-control mb-3"
                placeholder="Номер паспорта"
            />
            <div
                v-if="errorLoaded && errors.passport_number"
                class="text-danger"
            >
                {{ errors.passport_number[0] }}
            </div>

            <input
                v-model="city"
                type="text"
                class="form-control mb-3"
                placeholder="Город"
            />
            <div v-if="errorLoaded && errors.city" class="text-danger">
                {{ errors.city[0] }}
            </div>

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
            <div v-if="errorLoaded && errors.blood_group" class="text-danger">
                {{ errors.blood_group[0] }}
            </div>

            <input
                v-model="email"
                type="email"
                class="form-control mb-3"
                placeholder="Электронная почта"
            />
            <div v-if="errorLoaded && errors.email" class="text-danger">
                {{ errors.email[0] }}
            </div>

            <input
                v-model="password"
                type="password"
                class="form-control mb-3"
                placeholder="Пароль"
            />
            <div v-if="errorLoaded && errors.password" class="text-danger">
                {{ errors.password[0] }}
            </div>

            <input
                v-model="password_confirmation"
                type="password"
                class="form-control mb-3"
                placeholder="Подтвердите пароль"
            />
            <div
                v-if="errorLoaded && errors.password_confirmation"
                class="text-danger"
            >
                {{ errors.password_confirmation[0] }}
            </div>

            <input
                @click.prevent="store"
                type="submit"
                class="btn btn-primary"
                placeholder="Войти"
            />
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
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

let errors = ref({});
let errorLoaded = ref(false);

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
            authStore.login(res.data.access_token);
            router.push({ name: "user.personal" });
        })
        .catch((error) => {
            errorLoaded.value = true;
            if (
                error.response &&
                error.response.data &&
                error.response.data.errors
            ) {
                // Извлекаем данные из прокси-объекта и сохраняем в обычном объекте
                errors.value = { ...error.response.data.errors };
            } else {
                console.log(error);
                errors.value = { general: ["An unknown error occurred."] };
            }
            console.log(errors.value);
        });
}
</script>

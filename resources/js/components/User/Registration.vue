<template>
    <div class="w-25">
        <input
            v-model="userLastName"
            type="text"
            class="form-control bt-3 mb-3"
            placeholder="Фамилия"
        />
        <input
            v-model="userFirstName"
            type="text"
            class="form-control bt-3 mb-3"
            placeholder="Имя"
        />
        <input
            v-model="userMiddleName"
            type="text"
            class="form-control bt-3 mb-3"
            placeholder="Отчество"
        />
        <input
            v-model="userPassportSeries"
            type="text"
            class="form-control mb-3"
            placeholder="Серия паспорта"
        />
        <input
            v-model="userPassportNumber"
            type="text"
            class="form-control mb-3"
            placeholder="Номер паспорта"
        />
        <select v-model="cityId" class="form-control mb-3" placeholder="Город">
            <option value="" disabled>Выберите город</option>
            <option v-for="city in cities" :key="city.id" :value="city.id">
                {{ city.cityTitle }}
            </option>
        </select>
        <select
            v-model="bloodGroupId"
            class="form-control mb-3"
            placeholder="Группа крови"
        >
            <option value="" disabled>Выберите группу крови</option>
            <option
                v-for="bloodGroup in bloodGroups"
                :key="bloodGroup.id"
                :value="bloodGroup.id"
            >
                {{ bloodGroup.bloodGroupTitle }}
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
</template>
<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import router from "../../router";

//
let userLastName = ref(null);
let userFirstName = ref(null);
let userMiddleName = ref(null);
let userPassportSeries = ref(null);
let userPassportNumber = ref(null);
let email = ref(null);
let password = ref(null);
let password_confirmation = ref(null);

let cities = ref([]);
let bloodGroups = ref([]);

let cityId = ref(null);
let bloodGroupId = ref(null);

let Error = ref(null);

onMounted(() => {
    axios
        .get("/api/cities")
        .then((response) => {
            cities.value = response.data.data;
            console.log(cities.value);
        })
        .catch((error) => {
            console.error(error);
        });

    axios
        .get("/api/blood_groups")
        .then((response) => {
            bloodGroups.value = response.data.data;
            console.log(bloodGroups.value);
        })
        .catch((error) => {
            console.error(error);
        });
});

function store() {
    console.log(email.value);
    console.log(password.value);
    console.log(password_confirmation.value);
    console.log(userLastName.value);
    console.log(userFirstName.value);
    console.log(userMiddleName.value);
    console.log(userPassportSeries.value);
    console.log(userPassportNumber.value);
    console.log(cityId.value);
    console.log(bloodGroupId.value);
    axios
        .post("/api/users", {
            email: email.value,
            password: password.value,
            password_confirmation: password_confirmation.value,
            userLastName: userLastName.value,
            userFirstName: userFirstName.value,
            userMiddleName: userMiddleName.value,
            userPassportSeries: userPassportSeries.value,
            userPassportNumber: userPassportNumber.value,
            cityId: cityId.value,
            bloodGroupId: bloodGroupId.value,
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
                console.log(error);
                Error.value = "An unknown error occurred.";
            }
            console.log(Error.value);
        });
}
</script>

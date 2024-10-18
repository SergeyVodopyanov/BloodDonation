<template>
    <div v-if="user" class="row justify-content-center">
        <div class="col-6 bg-light p-4 mx-auto">
            <div class="user-profile card shadow-sm p-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Фамилия:</label>
                            <span class="form-control-plaintext">{{
                                user.userLastName
                            }}</span>
                        </div>
                        <div class="form-group">
                            <label>Имя:</label>
                            <span class="form-control-plaintext">{{
                                user.userFirstName
                            }}</span>
                        </div>
                        <div class="form-group">
                            <label>Отчество:</label>
                            <span class="form-control-plaintext">{{
                                user.userMiddleName
                            }}</span>
                        </div>
                        <div class="form-group">
                            <label>Колличество донаций:</label>
                            <span class="form-control-plaintext">{{
                                user.userDonationCount
                            }}</span>
                            <span class="form-control-plaintext text-muted">
                                {{
                                    userIsHonoraryDonor
                                        ? "Вы являетесь почётным донором!"
                                        : "Почётным донором можно стать после 40 донаций"
                                }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Серия паспорта:</label>
                            <span class="form-control-plaintext">{{
                                user.userPassportSeries
                            }}</span>
                        </div>
                        <div class="form-group">
                            <label>Номер паспорта:</label>
                            <span class="form-control-plaintext">{{
                                user.userPassportNumber
                            }}</span>
                        </div>
                        <div class="form-group">
                            <label>Город:</label>
                            <span class="form-control-plaintext">{{
                                userCity
                            }}</span>
                        </div>
                        <div class="form-group">
                            <label>Группа крови:</label>
                            <span class="form-control-plaintext">{{
                                userBloodGroup
                            }}</span>
                        </div>
                        <div class="form-group">
                            <label>Электронная почта:</label>
                            <span class="form-control-plaintext">{{
                                user.email
                            }}</span>
                        </div>
                        <div class="form-group">
                            <label>Пароль:</label>
                            <span class="form-control-plaintext"> ??? </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useRoute } from "vue-router";
import axios from "axios";
import { useAuthStore } from "../../stores/auth";

const authStore = useAuthStore();
const route = useRoute();

// let person = ref({});

let user = computed(() => authStore.user);
let userCity = ref(null);
let userBloodGroup = ref(null);
let cities = ref(null);
let bloodGroups = ref(null);

console.log(user.value); // Выведет объект пользователя

onMounted(() => {
    axios
        .get("/api/cities")
        .then((response) => {
            cities.value = response.data.data;
            // console.log(user.value.cityId);
            userCity.value = cities.value.find(
                (city) => city.id === user.value.cityId
            ).cityTitle;
            // console.log("sdsds" + userCity);
            // console.log(cities.value);
        })
        .catch((error) => {
            console.error(error);
        });

    axios
        .get("/api/blood_groups")
        .then((response) => {
            bloodGroups.value = response.data.data;
            // console.log(bloodGroups.value);
            userBloodGroup.value = bloodGroups.value.find(
                (bloodGroup) => bloodGroup.id === user.value.bloodGroupId
            ).bloodGroupTitle;
        })
        .catch((error) => {
            console.error(error);
        });
});
</script>

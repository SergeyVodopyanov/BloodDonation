<template>
    <div v-if="isDonationsLoaded">
        <div class="container mt-5">
            <div v-if="user" class="row justify-content-center">
                <div class="card shadow-sm p-4">
                    <h4 class="mb-4">Личные данные</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Фамилия:</label>
                                <span class="form-control-plaintext">{{
                                    user.last_name
                                }}</span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Имя:</label>
                                <span class="form-control-plaintext">{{
                                    user.first_name
                                }}</span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Отчество:</label>
                                <span class="form-control-plaintext">{{
                                    user.middle_name
                                }}</span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"
                                    >Кол-во донаций:</label
                                >
                                <span class="form-control-plaintext">{{
                                    donations.length
                                }}</span>
                                <span class="form-control-plaintext text-muted">
                                    {{
                                        donations.length >= 40
                                            ? "Вы являетесь почётным донором!"
                                            : "Почётным донором можно стать после 40 донаций"
                                    }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"
                                    >Серия паспорта:</label
                                >
                                <span class="form-control-plaintext">{{
                                    user.passport_series
                                }}</span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"
                                    >Номер паспорта:</label
                                >
                                <span class="form-control-plaintext">{{
                                    user.passport_number
                                }}</span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Город:</label>
                                <span class="form-control-plaintext">{{
                                    user.city
                                }}</span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Группа крови:</label>
                                <span class="form-control-plaintext">{{
                                    user.blood_group
                                }}</span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"
                                    >Электронная почта:</label
                                >
                                <span class="form-control-plaintext">{{
                                    user.email
                                }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mt-5">
                <div class="card shadow-sm p-4">
                    <h4 class="mb-4">История донаций</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Дата</th>
                                <th scope="col">Время</th>
                                <th scope="col">Учреждение</th>
                                <th scope="col">Адрес</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="donation in donations"
                                :key="donation.id"
                            >
                                <td>{{ donation.date }}</td>
                                <td>{{ donation.time }}</td>
                                <td>{{ donation.point.title }}</td>
                                <td>{{ donation.point.address }}</td>
                            </tr>
                        </tbody>
                    </table>
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

let user = computed(() => authStore.user);
let donations = ref(null);
let isDonationsLoaded = ref(null);

onMounted(() => {
    axios
        .get(`/api/auth/user/${user.value.id}/donations`, {
            headers: {
                authorization: `Bearer ${localStorage.getItem("access_token")}`,
            },
        })
        .then((response) => {
            isDonationsLoaded.value = true;
            console.log(response.data);
            donations.value = response.data;
            console.log(donations.value);
        })
        .catch((error) => {
            console.error("Error fetching donations:", error);
        });
});
</script>

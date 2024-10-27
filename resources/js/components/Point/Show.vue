<template>
    <div v-if="isPointLoaded">
        <div class="container">
            <div class="row">
                <div class="col-md-6 ml-0">
                    <div id="map" style="height: 400px"></div>
                </div>
                <div class="col-md-6">
                    <div>
                        <h1>Информация о пункте сдачи крови</h1>
                        <h5>Название: {{ point.title }}</h5>
                        <h5>Город: {{ point.city }}</h5>
                        <h5>Адрес: {{ point.address }}</h5>
                        <div class="d-flex align-items-center">
                            <div
                                style="
                                    background-color: red;
                                    width: 180px;
                                    height: 30px;
                                "
                            ></div>
                            <div style="margin-left: 25px">
                                - означает, что в учреждении сложилась
                                повышенная потребность в крови данной группы и
                                резус-принадлежности, рекомендуем запланировать
                                визит для плановой донации.
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div
                                style="
                                    background-color: green;
                                    width: 160px;
                                    height: 30px;
                                "
                            ></div>
                            <div style="margin-left: 25px">
                                - означает, что в учреждении имеется достаточный
                                запас крови данной группы и резус-принадлежности
                                и с визитом в Службу крови можно повременить.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Первая группа крови</th>
                    <th scope="col">Вторая группа крови</th>
                    <th scope="col">Третья группа крови</th>
                    <th scope="col">Четвёртая группа крови</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center">
                        <div
                            :style="{
                                backgroundColor:
                                    point.first_blood_group_count <
                                    point.enough_count
                                        ? 'red'
                                        : 'green',
                                width: '160px',
                                height: '30px',
                            }"
                        ></div>
                    </td>
                    <td style="text-align: center">
                        <div
                            :style="{
                                backgroundColor:
                                    point.second_blood_group_count <
                                    point.enough_count
                                        ? 'red'
                                        : 'green',
                                width: '160px',
                                height: '30px',
                            }"
                        ></div>
                    </td>
                    <td style="text-align: center">
                        <div
                            :style="{
                                backgroundColor:
                                    point.third_blood_group_count <
                                    point.enough_count
                                        ? 'red'
                                        : 'green',
                                width: '160px',
                                height: '30px',
                            }"
                        ></div>
                    </td>
                    <td style="text-align: center">
                        <div
                            :style="{
                                backgroundColor:
                                    point.fourth_blood_group_count <
                                    point.enough_count
                                        ? 'red'
                                        : 'green',
                                width: '160px',
                                height: '30px',
                            }"
                        ></div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="donation-form">
            <div class="form-group w-25">
                <label for="date">Выберите дату:</label>
                <flat-pickr v-model="selectedDate" :config="datePickerConfig" />
            </div>
            <!-- <div class="form-group">
                <label for="time">Выберите время:</label>
                <flat-pickr v-model="selectedTime" :config="timePickerConfig" />
            </div> -->
            <div class="form-group w-25">
                <label for="timePeriod">Выберите время:</label>
                <select
                    class="form-control"
                    id="timePeriod"
                    v-model="selectedTime"
                >
                    <option
                        v-for="time in availableTimes"
                        :key="time"
                        :value="time"
                    >
                        {{ time }}
                    </option>
                </select>
            </div>
            <!-- <div v-if="isPointLoaded">
                <button
                    @click="createDonation"
                    :disabled="bloodNeed.value"
                    class="btn btn-primary"
                >
                    Записаться на сдачу крови
                </button>
                <span v-if="bloodNeed.value === false" class="text-muted ml-2">
                    В данном пункте достаточно крови вашей группы
                </span>
            </div> -->
            <div>
                <button
                    :disabled="newDonationDate || showBloodNeedMessage"
                    @click="createDonation"
                    class="btn btn-primary"
                >
                    Записаться на сдачу крови
                </button>
                <span v-if="newDonationDate" class="text-muted ml-2">
                    Ближаяшая досупная дата сдачи крови: {{ newDonationDate }}
                </span>
                <span v-if="showBloodNeedMessage" class="text-muted ml-2">
                    В данном пункте достаточно крови вашей группы
                </span>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted, computed, watch, watchEffect } from "vue";
import { useRoute } from "vue-router";
import api from "../../api";
import { useAuthStore } from "../../stores/auth";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";

const route = useRoute();
const authStore = useAuthStore();

let user = computed(() => authStore.user);

// console.log(user.value.blood_group);

const point = ref(null);

let lastDonationDateLoaded = ref(null);
let lastDonationDate = ref(null);
let newDonationDate = ref(null);

let isPointLoaded = ref(false);

let bloodNeed = ref(null);
const showBloodNeedMessage = computed(() => !bloodNeed.value);

let allTimes = [
    "08:00:00",
    "08:15:00",
    "08:30:00",
    "08:45:00",
    "09:00:00",
    "09:15:00",
    "09:30:00",
    "09:45:00",
    "10:00:00",
    "10:15:00",
    "10:30:00",
    "10:45:00",
    "11:00:00",
    "11:15:00",
    "11:30:00",
    "11:45:00",
    "12:00:00",
    "12:15:00",
    "12:30:00",
    "12:45:00",
    "13:00:00",
    "13:15:00",
    "13:30:00",
    "13:45:00",
    "14:00:00",
    "14:15:00",
    "14:30:00",
    "14:45:00",
    "15:00:00",
    "15:15:00",
    "15:30:00",
    "15:45:00",
    "16:00:00",
];

let takenTimes = ref(null);
let availableTimes = ref(null);

const selectedDate = ref(null);
const selectedTime = ref(null);
const datePickerConfig = {
    dateFormat: "Y-m-d",
    enableTime: false,
};

onMounted(() => {
    const pointId = route.params.id;
    api.get(`/api/points/${pointId}`).then((res) => {
        point.value = res.data.data;
        isPointLoaded.value = true;
        updateBloodNeed();
        init();
    });
    axios
        .get(`/api/auth/user/${user.value.id}/last_donation`, {
            headers: {
                authorization: `Bearer ${localStorage.getItem("access_token")}`,
            },
        })
        .then((response) => {
            lastDonationDateLoaded.value = true;
            lastDonationDate.value = response.data.date;
            // console.log(lastDonationDate.value);
            newDonationDate.value = new Date(lastDonationDate.value);
            newDonationDate.value.setDate(newDonationDate.value.getDate() + 40);

            const today = new Date();
            if (newDonationDate.value < today) {
                newDonationDate.value = null;
            } else {
                const year = newDonationDate.value.getFullYear();
                const month = String(
                    newDonationDate.value.getMonth() + 1
                ).padStart(2, "0");
                const day = String(newDonationDate.value.getDate()).padStart(
                    2,
                    "0"
                );
                newDonationDate.value = `${year}-${month}-${day}`;
            }

            // console.log(newDonationDate.value);
        })
        .catch((error) => {
            console.error("Error fetching donations:", error);
        });
});

watch(point, () => {
    updateBloodNeed();
});

watchEffect(() => {
    const pointId = route.params.id;
    if (selectedDate.value) {
        axios
            .get(`/api/points/${pointId}/available_times`, {
                params: {
                    date: selectedDate.value,
                },
            })
            .then((response) => {
                takenTimes.value = response.data;
                availableTimes.value = allTimes.filter(
                    (item) => !takenTimes.value.includes(item)
                );
                // console.log("занятое время " + takenTimes.value);
                // console.log("свободное время " + availableTimes.value);
            })
            .catch((error) => {
                console.error("Ошибка при получении доступных времен:", error);
            });
    } else {
        takenTimes.value = [];
    }
});

function updateBloodNeed() {
    if (user.value.blood_group === "Первая группа крови") {
        bloodNeed.value =
            point.value.first_blood_group_count < point.value.enough_count;
    } else if (user.value.blood_group === "Вторая группа крови") {
        bloodNeed.value =
            point.value.second_blood_group_count < point.value.enough_count;
    } else if (user.value.blood_group === "Третья группа крови") {
        bloodNeed.value =
            point.value.third_blood_group_count < point.value.enough_count;
    } else {
        bloodNeed.value =
            point.value.fourth_blood_group_count < point.value.enough_count;
    }
    console.log("bloodNeed.value:", bloodNeed.value);
}

function createDonation() {
    if (!user.value) {
        console.error(
            "Пользователь не авторизован или данные о пользователе не загружены."
        );
        return;
    }

    const userId = user.value.id;
    const pointId = point.value.id;

    // console.log("id пользователя:", userId);
    // console.log("id пункта сдачи крови:", pointId);
    // console.log("Дата:", selectedDate.value);
    // console.log("Время:", selectedTime.value);

    axios
        .post("/api/donations", {
            user_id: userId,
            point_id: pointId,
            date: selectedDate.value,
            time: selectedTime.value,
        })
        .then((response) => {
            // console.log(response.data);
        })
        .catch((error) => {
            console.error(error);
        });
}

function init() {
    if (!isPointLoaded.value) return; // Проверяем, загружены ли данные
    let pointOnMap = point.value;
    let [latitude, longitude] = pointOnMap.geolocation.split(", ");
    ymaps.ready(() => {
        var myMap = new ymaps.Map("map", {
            center: [latitude, longitude],
            zoom: 10,
        });

        let pointsOnMap = [];

        let newPoint = {
            coordinates: [latitude, longitude],
            title: pointOnMap.title,
            description: pointOnMap.address,
        };
        pointsOnMap.push(newPoint);

        pointsOnMap.forEach(function (pointOnMap) {
            var placemark = new ymaps.Placemark(pointOnMap.coordinates, {
                balloonContentHeader: pointOnMap.title,
                balloonContentBody: pointOnMap.description,
            });
            myMap.geoObjects.add(placemark);
        });
    });
}
</script>

<style>
#map {
    width: 100%;
    height: 500px;
}
</style>

<style scoped>
.donation-form {
    margin: 20px 0;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.btn-primary {
    margin-top: 10px;
}
</style>

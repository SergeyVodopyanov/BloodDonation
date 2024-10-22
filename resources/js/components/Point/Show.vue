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
                                    width: 160px;
                                    height: 30px;
                                "
                            ></div>
                            <div class="margin-left: 50px">
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
                            <div class="margin-left: 50px">
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
            <div class="form-group">
                <label for="date">Выберите дату:</label>
                <flat-pickr v-model="selectedDate" :config="datePickerConfig" />
            </div>
            <div class="form-group">
                <label for="time">Выберите время:</label>
                <flat-pickr v-model="selectedTime" :config="timePickerConfig" />
            </div>
            <button @click="createDonation" class="btn btn-primary">
                Записаться на сдачу крови
            </button>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted, computed } from "vue";
import { useRoute } from "vue-router";
import api from "../../api";
import { useAuthStore } from "../../stores/auth";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";

const route = useRoute();
const authStore = useAuthStore();

let user = computed(() => authStore.user);

const point = ref(null);

let isPointLoaded = ref(false);

const selectedDate = ref(null);
const selectedTime = ref(null);
const datePickerConfig = {
    dateFormat: "Y-m-d",
    enableTime: false,
};
const timePickerConfig = {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true,
};

onMounted(() => {
    const pointId = route.params.id;
    api.get(`/api/points/${pointId}`).then((res) => {
        point.value = res.data.data;
        console.log("Значение point.value после axios-запроса");

        console.log(point.value);
        isPointLoaded.value = true;
        init();
    });
});

function createDonation() {
    if (!user.value) {
        console.error(
            "Пользователь не авторизован или данные о пользователе не загружены."
        );
        return;
    }

    // const donationSessionId = Math.floor(
    //     Math.random() * point.value.donationSessions.length
    // );
    const userId = user.value.id;
    const pointId = point.value.id;

    console.log("id пользователя:", userId);
    console.log("id пункта сдачи крови:", pointId);
    console.log("Дата:", selectedDate.value);
    console.log("Время:", selectedTime.value);

    axios
        .post("/api/donations", {
            user_id: userId,
            point_id: pointId,
            date: selectedDate.value,
            time: selectedTime.value,
        })
        .then((response) => {
            console.log(response.data);
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
            // center: [55.76, 37.64],
            center: [latitude, longitude],
            zoom: 10,
        });

        // Массив с данными о пунктах сдачи крови
        let pointsOnMap = [];

        // let pointOnMap = point.value;
        console.log(pointOnMap);
        // let [latitude, longitude] = pointOnMap.geolocation.split(", ");

        let newPoint = {
            coordinates: [latitude, longitude],
            title: pointOnMap.title,
            description: pointOnMap.address,
        };
        pointsOnMap.push(newPoint);

        // Добавляем метки на карту
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

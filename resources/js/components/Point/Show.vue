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
        <button @click="addBloodDonation" class="btn btn-primary">
            Добавить запись о сдаче крови
        </button>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted, computed } from "vue";
import { useRoute } from "vue-router";
import api from "../../api";
import { useAuthStore } from "../../stores/auth";

const route = useRoute();
const authStore = useAuthStore();

let user = computed(() => authStore.user);

console.log(user.value);

const point = ref(null);

let isPointLoaded = ref(false);

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

function addBloodDonation() {
    if (!user.value) {
        console.error(
            "Пользователь не авторизован или данные о пользователе не загружены."
        );
        return;
    }

    const donationSessionId = Math.floor(
        Math.random() * point.value.donationSessions.length
    );
    const userId = user.value.id;

    console.log("donationSessionId:", donationSessionId);
    console.log("userId:", userId);

    axios
        .post("/api/bloodDonations", {
            donationSessionId: donationSessionId,
            userId: userId,
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

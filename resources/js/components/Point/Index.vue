<template>
    <div id="map"></div>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Название</th>
                    <th scope="col">Город</th>
                    <th scope="col">Адрес</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="point in points"
                    :key="point.id"
                    @click="goToPointShow(point.id)"
                    style="cursor: pointer"
                >
                    <td>{{ point.title }}</td>
                    <td>{{ point.city }}</td>
                    <td>{{ point.address }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, computed } from "vue";
import { useRouter } from "vue-router";
import api from "../../api";

let router = useRouter();

let points = ref(null);
let cities = ref([]);
let selectedCity = ref("");
let isPointsLoaded = ref(false);

getPoints(api);

function getPoints(api) {
    api.get("/api/points", {
        // headers: {
        //     Authorization: `Bearer ${localStorage.getItem("access_token")}`,
        // },
    }).then((res) => {
        points.value = res.data.data;
        console.log(points.value);
        isPointsLoaded.value = true;
        init(); // Вызываем init только после загрузки данных
    });
}

function goToPointShow(pointId) {
    router.push({
        name: "point.show",
        params: { id: pointId },
    });
}

function init() {
    if (!isPointsLoaded.value) return; // Проверяем, загружены ли данные

    ymaps.ready(() => {
        var myMap = new ymaps.Map("map", {
            center: [55.76, 37.64],
            zoom: 10,
        });

        // Массив с данными о пунктах сдачи крови
        let pointsOnMap = [];
        for (let i = 0; i < points.value.length; i++) {
            let pointOnMap = points.value[i];
            console.log(pointOnMap);
            let [latitude, longitude] = pointOnMap.geolocation.split(", ");

            let newPoint = {
                coordinates: [latitude, longitude],
                title: pointOnMap.title,
                description: pointOnMap.address,
            };
            pointsOnMap.push(newPoint);
        }

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

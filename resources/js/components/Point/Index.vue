<template>
    <div>
        <div id="map"></div>

        <div>
            <label for="cityFilter">Выберите город:</label>
            <select id="cityFilter" v-model="selectedCity">
                <option value="">Все города</option>
                <option v-for="city in uniqueCities" :key="city" :value="city">
                    {{ city }}
                </option>
            </select>
        </div>

        <div>
            <label for="bloodGroupFilter">Выберите группу крови:</label>
            <select id="bloodGroupFilter" v-model="selectedBloodGroup">
                <option value="">Все группы</option>
                <option value="1">Первая группа</option>
                <option value="2">Вторая группа</option>
                <option value="3">Третья группа</option>
                <option value="4">Четвертая группа</option>
            </select>
        </div>

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
                        v-for="point in filteredPoints"
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
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, computed } from "vue";
import { useRouter } from "vue-router";
import api from "../../api";

let router = useRouter();

let points = ref(null);
let selectedCity = ref("");
let selectedBloodGroup = ref("");
let isPointsLoaded = ref(false);

getPoints(api);

function getPoints(api) {
    api.get("/api/points", {
        // headers: {
        //     Authorization: `Bearer ${localStorage.getItem("access_token")}`,
        // },
    }).then((res) => {
        points.value = res.data.data;
        isPointsLoaded.value = true;
        init();
        points.value.forEach((point) => {
            point.first_need =
                point.first_blood_group_count < point.enough_count;
            point.second_need =
                point.second_blood_group_count < point.enough_count;
            point.third_need =
                point.third_blood_group_count < point.enough_count;
            point.fourth_need =
                point.fourth_blood_group_count < point.enough_count;
        });
        console.log(points.value);
    });
}

const uniqueCities = computed(() => {
    return [...new Set(points.value?.map((point) => point.city))];
});

const filteredPoints = computed(() => {
    if (!points.value) return [];

    return points.value.filter((point) => {
        const cityMatch =
            !selectedCity.value || point.city === selectedCity.value;

        let bloodGroupMatch = true;
        if (selectedBloodGroup.value) {
            if (selectedBloodGroup.value === "1")
                bloodGroupMatch = point.first_need;
            if (selectedBloodGroup.value === "2")
                bloodGroupMatch = point.second_need;
            if (selectedBloodGroup.value === "3")
                bloodGroupMatch = point.third_need;
            if (selectedBloodGroup.value === "4")
                bloodGroupMatch = point.fourth_need;
        }

        return cityMatch && bloodGroupMatch;
    });
});

function goToPointShow(pointId) {
    router.push({
        name: "point.show",
        params: { id: pointId },
    });
}

function init() {
    if (!isPointsLoaded.value) return;

    ymaps.ready(() => {
        var myMap = new ymaps.Map("map", {
            center: [55.76, 37.64],
            zoom: 10,
        });

        let pointsOnMap = [];
        for (let i = 0; i < filteredPoints.value.length; i++) {
            let pointOnMap = filteredPoints.value[i];
            let [latitude, longitude] = pointOnMap.geolocation.split(", ");

            let newPoint = {
                coordinates: [latitude, longitude],
                title: pointOnMap.title,
                description: pointOnMap.address,
            };
            pointsOnMap.push(newPoint);
        }

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

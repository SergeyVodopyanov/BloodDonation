<template>
    <div v-if="isStationLoaded">
        <div id="map"></div>
        <div>
            <h1>Информация о пункте сдачи крови</h1>
            <p>Название: {{ station.bloodDonationStationTitle }}</p>
            <p>
                Город:
                {{ station.city ? station.city.cityTitle : "Неизвестно" }}
            </p>
            <p>Адрес: {{ station.bloodDonationStationAddress }}</p>
            <p>
                Геолокация: {{ station.bloodDonationStationLatitude }}
                {{ station.bloodDonationStationLongitude }}
            </p>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Название</th>
                    <th scope="col">Город</th>
                    <th scope="col">Адрес</th>
                    <th scope="col">Геолокация</th>
                    <th scope="col">O(I) Rh+</th>
                    <th scope="col">O(I) Rh−</th>
                    <th scope="col">A(II) Rh+</th>
                    <th scope="col">A(II) Rh−</th>
                    <th scope="col">B (III) Rh+</th>
                    <th scope="col">B (III) Rh−</th>
                    <th scope="col">AB (IV) Rh+</th>
                    <th scope="col">AB (IV) Rh−</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">{{ station.id }}</th>
                    <td>{{ station.bloodDonationStationTitle }}</td>
                    <td>{{ station.city.cityTitle }}</td>
                    <td>{{ station.bloodDonationStationAddress }}</td>
                    <td>
                        {{
                            station.bloodDonationStationLatitude +
                            " " +
                            station.bloodDonationStationLongitude
                        }}
                    </td>
                    <td>
                        {{
                            getBloodGroupStatus(station, "Первая положительная")
                        }}
                    </td>
                    <td>
                        {{
                            getBloodGroupStatus(station, "Первая отрицательная")
                        }}
                    </td>
                    <td>
                        {{
                            getBloodGroupStatus(station, "Вторая положительная")
                        }}
                    </td>
                    <td>
                        {{
                            getBloodGroupStatus(station, "Вторая отрицательная")
                        }}
                    </td>
                    <td>
                        {{
                            getBloodGroupStatus(station, "Третья положительная")
                        }}
                    </td>
                    <td>
                        {{
                            getBloodGroupStatus(station, "Третья отрицательная")
                        }}
                    </td>
                    <td>
                        {{
                            getBloodGroupStatus(
                                station,
                                "Четвёртая положительная"
                            )
                        }}
                    </td>
                    <td>
                        {{
                            getBloodGroupStatus(
                                station,
                                "Четвёртая отрицательная"
                            )
                        }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import api from "../../api";

const route = useRoute();
const station = ref({});

let isStationLoaded = ref(false);

onMounted(() => {
    const stationId = route.params.id;
    api.get(`/api/stations/${stationId}`).then((res) => {
        station.value = res.data.data;
        console.log(station.value);
        isStationLoaded.value = true;
        init();
    });
});

function getBloodGroupStatus(station, bloodGroupTitle) {
    const bloodGroup = station.bloodGroups.find(
        (group) => group.bloodGroupTitle === bloodGroupTitle
    );
    if (bloodGroup) {
        if (bloodGroup.bloodInStationEnough === true) {
            return "Не требуется";
        } else if (bloodGroup.bloodInStationEnough === false) {
            return "Требуется";
        }
    } else return "Неизвестно";
}

function init() {
    if (!isStationLoaded.value) return; // Проверяем, загружены ли данные
    ymaps.ready(() => {
        var myMap = new ymaps.Map("map", {
            center: [55.76, 37.64], // Координаты центра карты (Москва)
            zoom: 10, // Масштаб карты
        });
        // Массив с данными о пунктах сдачи крови
        let points = [];
        // for (let i = 0; i < stations.value.length; i++) {
        //     let station = stations.value[i];
        //     console.log(station.value);
        //     let newPoint = {
        //         coordinates: [
        //             station.value.bloodDonationStationLatitude,
        //             station.value.bloodDonationStationLongitude,
        //         ],
        //         title: station.value.bloodDonationStationTitle,
        //         description: station.value.bloodDonationStationAddress,
        //     };
        //     points.push(newPoint);
        // }
        // let station = stations.value[i];
        console.log(station.value);
        let newPoint = {
            coordinates: [
                station.value.bloodDonationStationLatitude,
                station.value.bloodDonationStationLongitude,
            ],
            title: station.value.bloodDonationStationTitle,
            description: station.value.bloodDonationStationAddress,
        };
        points.push(newPoint);
        // Добавляем метки на карту
        points.forEach(function (point) {
            var placemark = new ymaps.Placemark(point.coordinates, {
                balloonContentHeader: point.title,
                balloonContentBody: point.description,
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

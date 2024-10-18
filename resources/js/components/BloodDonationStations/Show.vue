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

console.log(user.value); // Выведет объект пользователя
// console.log(user.value.id); // Должен вывести ID пользователя

const station = ref({});

let isStationLoaded = ref(false);

onMounted(() => {
    const stationId = route.params.id;
    api.get(`/api/stations/${stationId}`).then((res) => {
        station.value = res.data.data;
        // console.log(station.value);
        isStationLoaded.value = true;
        init();
    });
});
function addBloodDonation() {
    // console.log(station.value.donationSessions.length);
    if (!user.value) {
        console.error(
            "Пользователь не авторизован или данные о пользователе не загружены."
        );
        return;
    }

    const donationSessionId = Math.floor(
        Math.random() * station.value.donationSessions.length
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
    if (!isStationLoaded.value) return;
    ymaps.ready(() => {
        var myMap = new ymaps.Map("map", {
            center: [55.76, 37.64],
            zoom: 10,
        });

        let points = [];

        // console.log(station.value);
        let newPoint = {
            coordinates: [
                station.value.bloodDonationStationLatitude,
                station.value.bloodDonationStationLongitude,
            ],
            title: station.value.bloodDonationStationTitle,
            description: station.value.bloodDonationStationAddress,
        };
        points.push(newPoint);

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

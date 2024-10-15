<template>
    <div>
        <div class="mb-3">
            <label for="cityFilter" class="form-label">Фильтр по городу:</label>
            <select
                v-model="selectedCity"
                class="form-select"
                id="cityFilter"
                @change="filterStations"
            >
                <option value="">Все города</option>
                <option
                    v-for="city in cities"
                    :key="city.id"
                    :value="city.cityTitle"
                >
                    {{ city.cityTitle }}
                </option>
            </select>
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
                <tr v-for="station in filteredStations" :key="station.id">
                    <th scope="row">{{ station.id }}</th>
                    <td>{{ station.bloodDonationStationTitle }}</td>
                    <td>{{ station.city.cityTitle }}</td>
                    <td>{{ station.bloodDonationStationAddress }}</td>
                    <td>{{ station.bloodDonationStationGeolocation }}</td>
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
import { ref, computed } from "vue";
import { useRouter } from "vue-router";
import api from "../../api";

let router = useRouter();

let stations = ref(null);
let cities = ref([]);
let selectedCity = ref("");

getStations(api);
getCities(api);

function getStations(api) {
    api.get("/api/stations", {
        // headers: {
        //     Authorization: `Bearer ${localStorage.getItem("access_token")}`,
        // },
    }).then((res) => {
        stations.value = res.data.data;
        console.log(stations.value);
    });
}

function getCities(api) {
    api.get("/api/cities", {
        // headers: {
        //     Authorization: `Bearer ${localStorage.getItem("access_token")}`,
        // },
    }).then((res) => {
        cities.value = res.data.data;
        console.log(cities.value);
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

const filteredStations = computed(() => {
    if (!stations.value) return [];
    if (!selectedCity.value) return stations.value;
    return stations.value.filter(
        (station) => station.city.cityTitle === selectedCity.value
    );
});

function filterStations() {
    // Эта функция вызывается при изменении выбранного города
    // Вычисление filteredStations будет автоматически обновлено
}
</script>

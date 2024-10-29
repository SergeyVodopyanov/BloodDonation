<template>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Ф.И.О.</th>
                    <th scope="col">Город</th>
                    <th scope="col">Количество донаций</th>
                    <th scope="col">Стал почётном донором</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="donor in honorary_donors"
                    :key="donor.id"
                    @click="goToPointShow(donor.id)"
                    style="cursor: pointer"
                >
                    <td>
                        {{
                            donor.last_name +
                            " " +
                            donor.first_name +
                            " " +
                            donor.middle_name
                        }}
                    </td>
                    <td>{{ donor.city }}</td>
                    <td>{{ donor.donations_count }}</td>
                    <td>{{ donor.honorary_donor }}</td>
                    <!-- <td>{{ donor.city }}</td>
                    <td>{{ donor.address }}</td> -->
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";

let honorary_donors = ref(null);
let honoraryDonorsLoaded = ref(null);

axios.get("/api/users/honorary_donors").then((res) => {
    console.log(res);
    honorary_donors.value = res.data.data;
    honoraryDonorsLoaded = true;
    console.log(honorary_donors.value);
});
</script>

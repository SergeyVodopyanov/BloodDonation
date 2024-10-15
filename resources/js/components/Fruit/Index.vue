<template>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="fruit in fruits" :key="fruit.id">
                    <th scope="row">{{ fruit.id }}</th>
                    <td>{{ fruit.name }}</td>
                    <td>{{ fruit.price }}</td>
                </tr>
                <!-- <tr v-for="(fruit, index) in fruits" :key="index">
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ fruit.name }}</td>
                    <td>{{ fruit.price }}</td>
                </tr> -->
            </tbody>
        </table>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref } from "vue";
import { useRouter } from "vue-router";
import api from "../../api";

let router = useRouter();

let fruits = ref(null);
// let api = initApi();
// export default api;

getFruits(api);

function getFruits(api) {
    api.get("/api/auth/fruits", {
        headers: {
            Authorization: `Bearer ${localStorage.getItem("access_token")}`,
        },
    }).then((res) => {
        fruits.value = res.data.data;
    });
}
</script>

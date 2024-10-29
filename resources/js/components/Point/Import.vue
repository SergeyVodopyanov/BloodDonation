<template>
    <div>
        <input type="file" @change="onFileChange" />
        <button @click="uploadFile">Загрузить</button>
    </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";

const file = ref(null);

const onFileChange = (event) => {
    file.value = event.target.files[0];
};

const uploadFile = () => {
    const formData = new FormData();
    formData.append("file", file.value);

    axios
        .post("/api/points/import", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        })
        .then((response) => {
            alert("Пункты сдачи крвои загружены");
        })
        .catch((error) => {
            console.error(error);
            alert("Ошибка при загрузке файла");
        });
};
</script>

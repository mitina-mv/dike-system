<template>
    <div>
        <div v-for="(field, index) in fields" :key="index">
            <input
                v-model="field.lastname"
                placeholder="Фамилия"
                :name="'items[' + index + '][lastname]'"
            />
            <input
                v-model="field.firstname"
                placeholder="Имя"
                :name="'items[' + index + '][firstname]'"
            />
            <input
                v-model="field.patronymic"
                placeholder="Отчество"
                :name="'items[' + index + '][patronymic]'"
            />
            <input
                v-model="field.user_email"
                placeholder="Email"
                :name="'items[' + index + '][user_email]'"
            />

            <multiselect
                v-model="field.group"
                :options="groups"
                :multiple="true"
                :taggable="true"
                label="studgroup_name"
                track-by="id"
                placeholder="Связанные группы"
                :name="'items[' + index + '][studgroup]'"
            ></multiselect>

            <button @click="removeField(index)">Удалить</button>
        </div>
        <div @click="addField">Добавить группу полей</div>
        <button @click="sendData">Сохранить</button>
    </div>
</template>

<script>
import Multiselect from "vue-multiselect";

export default {
    props: ["groups"],

    components: { Multiselect },

    data() {
        return {
            fields: [
                { lastname: "", firstname: "", patronymic: "", group: [], user_email: "" },
            ],
        };
    },

    methods: {
        addField() {
            this.fields.push({
                lastname: "",
                firstname: "",
                patronymic: "",
                group: [],
                user_email: "",
            });
        },
        removeField(index) {
            this.fields.splice(index, 1);
        },
        sendData(event) {
            event.preventDefault();
            axios
                .post("/users/teacher", {items: this.fields})
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
    },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

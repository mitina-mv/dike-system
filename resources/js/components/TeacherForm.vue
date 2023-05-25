<template>
    <div>
        <div v-for="(field, index) in fields" :key="index">
            <div class="form-group">
                <label for="">Фамилия</label>
                <input
                    type="text"
                    class="form-control"
                    placeholder="Фамилия"
                    :name="'items[' + index + '][lastname]'"
                    v-model="field.lastname"
                />
            </div>
            
            <div class="form-group">
                <label for="">Имя</label>
                <input
                    type="text"
                    class="form-control"
                    placeholder="Имя"
                    :name="'items[' + index + '][firstname]'"
                    v-model="field.firstname"
                />
            </div>
            
            <div class="form-group">
                <label for="">Отчество</label>
                <input
                    type="text"
                    class="form-control"
                    placeholder="Отчество"
                    :name="'items[' + index + '][patronymic]'"
                    v-model="field.patronymic"
                />
            </div>
            
            <div class="form-group">
                <label for="">Email</label>
                <input
                    type="text"
                    class="form-control"
                    placeholder="Email"
                    :name="'items[' + index + '][user_email]'"
                    v-model="field.user_email"
                />
            </div>

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

<template>
    <div>
        <div
            v-for="(field, index) in fields"
            :key="index"
            class="student-form__item mt-3"
        >
            <input
                v-model="field.surname"
                placeholder="Фамилия"
                class="form-control"
                :name="'items[' + index + '][lastname]'"
            />
            <input
                v-model="field.name"
                placeholder="Имя"
                class="form-control"
                :name="'items[' + index + '][firstname]'"
            />
            <input
                v-model="field.patronymic"
                placeholder="Отчество"
                class="form-control"
                :name="'items[' + index + '][patronymic]'"
            />
            <input
                v-model="field.email"
                placeholder="Email"
                class="form-control"
                :name="'items[' + index + '][user_email]'"
            />

            <select
                v-model="field.group"
                :name="'items[' + index + '][studgroup]'"
                class="form-control"
            >
                <option
                    :value="group.id"
                    v-for="(group, igroup) in groups"
                    :key="igroup"
                >
                    {{ group.studgroup_name }}
                </option>
            </select>

            <button @click="removeField(index)" class="btn btn-danger">
                Удалить
            </button>
        </div>
        <div @click="addField" class="btn btn-outline-primary mt-3">
            Добавить группу полей
        </div>
    </div>
</template>

<script lang="ts">
export default {
    props: ["groups"],

    data() {
        return {
            fields: [
                { surname: "", name: "", patronymic: "", group: "", email: "" },
            ],
        };
    },

    methods: {
        addField() {
            this.fields.push({
                surname: "",
                name: "",
                patronymic: "",
                group: "",
                email: "",
            });
        },
        removeField(index) {
            this.fields.splice(index, 1);
        },
    },
};
</script>

<style scoped>
.student-form__item {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 10px 20px;
}
</style>

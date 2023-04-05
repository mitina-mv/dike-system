<template>
    <div>
        <div v-for="(field, index) in fields" :key="index">
            <input v-model="field.surname" placeholder="Фамилия"/>
            <input v-model="field.name" placeholder="Имя"/>
            <input v-model="field.patronymic" placeholder="Отчество"/>
            <select v-model="field.group">
                <option value="1">Группа 1</option>
                <option value="2">Группа 2</option>
                <option value="3">Группа 3</option>
            </select>
            <button @click="removeField(index)">Удалить</button>
        </div>
        <button @click="addField">Добавить группу полей</button>
    </div>
</template>
  
<script lang="ts">
    export default {
        data() {
            return {
                fields: [
                {surname: '', name: '', patronymic: '', group: ''},
                ]
            };
        },
        methods: {
            addField() {
                this.fields.push({surname: '', name: '', patronymic: '', group: ''});
            },
            removeField(index) {
                this.fields.splice(index, 1);
            }
        }
    };
</script>
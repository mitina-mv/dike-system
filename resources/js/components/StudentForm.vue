<template>
    <div>
        <div v-for="(field, index) in fields" :key="index">
            <input v-model="field.surname" 
                placeholder="Фамилия" 
                :name="'items[' + index +'][lastname]'"
            />
            <input v-model="field.name" 
                placeholder="Имя" 
                :name="'items[' + index +'][firstname]'"
            />
            <input v-model="field.patronymic" 
                placeholder="Отчество" 
                :name="'items[' + index +'][patronymic]'"
            />
            <input v-model="field.email" 
                placeholder="Email" 
                :name="'items[' + index +'][user_email]'"
            />

            <select v-model="field.group" :name="'items[' + index +'][studgroup]'">
                <option :value="group.id" v-for="(group, igroup) in groups" :key="igroup">
                    {{ group.studgroup_name }}
                </option>
            </select>

            <button @click="removeField(index)">Удалить</button>
        </div>
        <div @click="addField">Добавить группу полей</div>
    </div>
</template>
  
<script lang="ts">
    export default {
        props: ['groups'],

        data() {
            return {
                fields: [
                    {surname: '', name: '', patronymic: '', group: '', email: ''},
                ]
            };
        },

        methods: {
            addField()
            {
                this.fields.push({surname: '', name: '', patronymic: '', group: '', email: ''});
            },
            removeField(index)
            {
                this.fields.splice(index, 1);
            }
        }
    };
</script>
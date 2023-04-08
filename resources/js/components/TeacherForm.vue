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

            <multiselect v-model="field.group" :options="groups" :multiple="true" :taggable="true" label="studgroup_name" track-by="id" tag-placeholder="Связанные группы" :name="'items[' + index +'][studgroup]'"></multiselect>

            <!-- <select v-model="field.group" :name="'items[' + index +'][studgroup]'" multiple>
                <option :value="group.id" v-for="(group, igroup) in groups" :key="igroup">
                    {{ group.studgroup_name }}
                </option>
            </select> -->

            <button @click="removeField(index)">Удалить</button>
        </div>
        <div @click="addField">Добавить группу полей</div>
        <button @click="sendData">Сохранить</button>
    </div>
</template>
  
<script>
    import Multiselect from 'vue-multiselect';

    export default {
        props: ['groups'],
        components: { Multiselect },
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
                console.log(this.fields);
                
            },
            removeField(index)
            {
                this.fields.splice(index, 1);
            },
            sendData(event)
            {
                event.preventDefault();
                axios.post('/users/teacher', this.fields)
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        }
    };
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
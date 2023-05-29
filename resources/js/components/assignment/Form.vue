<template>
    <div>
        <FormulateForm #default="{ hasErrors }">
            <div class="left">
                <FormulateInput 
                    v-for="(studgroup, index) in studgroups"
                    :key="index"
                    type="group"
                >
                    <FormulateInput 
                        type="checkbox"
                        :label="studgroup.name"
                        @click="toggleStudgroup(index)"
                        v-model="studgroupsCheck[index]"
                        class="group-checkbox"
                    />
                    <FormulateInput
                        v-model="studentsCheck"
                        type="checkbox"
                        :options="studgroups[index].students"
                        validation="required|min:1,length"
                    />
                </FormulateInput>
            </div>
            <div class="right">
                <FormulateInput
                    v-model="testId"
                    :options="tests"
                    type="select"
                    placeholder="Ваши шаблоны тестов"
                    label="Выберите тест"
                    validation="required"
                />
                <FormulateInput
                    type="datetime-local"
                    label="Дата / время проведения тестирования"
                    validation="required"
                />

                <FormulateInput 
                    type="submit" 
                    :disabled="hasErrors"
                    label="Назначить"
                    @click="send"
                />

            </div>
        </FormulateForm>
    </div>
</template>

<script>
import { indexOf } from 'lodash';
export default {
    props: {
        studgroups: {
            require: true,
        },
        tests: {
            require: true,
        },
    },
    data() {
        return {
            studgroupsCheck: [],
            studentsCheck: [],
            studentsOptions: [],
            testId: null
        };
    },
    mounted() 
    {
        for(let index in this.studgroups){
            this.studgroupsCheck[index] = false
        }
    }, 
    methods: 
    {
        toggleStudgroup(index) 
        {
            let studentsId = Object.keys(this.studgroups[index].students);
            if(!this.studgroupsCheck[index])
            {
                // включили, выбираем
                studentsId.forEach(id => {
                    if(indexOf(this.studentsCheck, id) == -1){
                        this.studentsCheck.push(id)
                    }
                })
            } else {
                // отключили, вырубаем
                studentsId.forEach(id => {
                    let pos = indexOf(this.studentsCheck, id)
                    if(pos !== -1){
                        this.studentsCheck.splice(pos, 1)
                    }
                })
            }
        }, 
        send()
        {

        }
    }
};
</script>

<style scoped>
.group-checkbox {
    background: #d7ffdb;
    padding: 5px 10px;
    margin-bottom: 10px;
}
form.formulate-form {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 24px;
}

.left {
    max-height: 65vh;
    overflow-y: auto;
}
</style>

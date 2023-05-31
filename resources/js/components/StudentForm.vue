<template>
    <div class="form-wrapper formulate-student-group">
        <FormulateForm v-model="formData" #default="{ hasErrors }">
            <FormulateInput
                type="group"
                name="items"
                :repeatable="true"
                label="Введите данные студентов"
                add-label="+ Добавить поля"
                validation="required"
            >
                <div class="attendee">
                    <FormulateInput
                        name="lastname"
                        validation="required"
                        label="Фамилия"
                    />
                    <FormulateInput
                        name="firstname"
                        validation="required"
                        label="Имя"
                    />
                    <FormulateInput
                        name="patronymic"
                        label="Отчество"
                    />
                    <FormulateInput
                        type="email"
                        name="user_email"
                        validation="required|email"
                        label="Email"
                    />
                    <FormulateInput
                        type="select"
                        name="studgroup"
                        label="Группа студентов"
                        :options="groups"
                    />
                </div>
            </FormulateInput>

            <FormulateInput 
                type="submit" 
                :disabled="hasErrors"
                label="Сохранить"
                @click="send"
            />
        </FormulateForm>
    </div>
</template>

<script>
export default {
    props: ['groups'],
    data() {
        return {
            formData: {}
        }
    },
    methods: 
    {
        send()
        {
            axios.post('/users/student', this.formData)
            .then((res) => {
                this.$notify({
                    title: "Добавление студентов",
                    text: res.data.message ? res.data.message : "Успешно!",
                    type: "success",
                });
            })
            .catch((error) => {
                this.$notify({
                    title: "Добавление студентов",
                    text: error.response.data.message,
                    type: "error",
                });
            });
        }
    }
};
</script>

<style>
.formulate-student-group .formulate-input-grouping {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    width: 100%;
}

.formulate-student-group .formulate-input-element.formulate-input-element--group.formulate-input-group {
    max-width: 100%;
}
</style>
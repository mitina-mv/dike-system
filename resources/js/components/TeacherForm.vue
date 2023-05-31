<template>
    <div class="form-wrapper formulate-student-group">
        <FormulateForm v-model="formData" #default="{ hasErrors }">
            <p>
                Введите данные преподавателей. Помните, при первом входе в систему им следует использовать в качестве пароль email. Предупредите их, что при первом входе им лучше поменять свой пароль на странице профиля.<br>
                Также отметим, что администратор не может изменять пароли других пользователей.
            </p>

            <FormulateInput
                type="group"
                name="items"
                :repeatable="true"
                label="Введите данные преподаателей"
                add-label="+ Добавить поля"
                validation="required"
            >
                <div class="attendee">
                    <FormulateInput
                        name="lastname"
                        validation="required|max:255,length"
                        label="Фамилия"
                    />
                    <FormulateInput
                        name="firstname"
                        validation="required|max:255,length"
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
                        class="groups-block"
                        type="checkbox"
                        validation="required|min:1"
                        name="group"
                        label="Группы студентов"
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
            axios.post('/users/teacher', this.formData)
            .then((res) => {
                this.$notify({
                    title: "Добавление преподавателей",
                    text: res.data.message ? res.data.message : "Успешно!",
                    type: "success",
                });
            })
            .catch((error) => {
                this.$notify({
                    title: "Добавление преподавателей",
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
.groups-block [role=group] {
    max-height: 150px;
    overflow-y: auto;
}
</style>

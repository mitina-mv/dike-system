<template>
    <FormulateForm v-model="formValues" @submit="send" #default="{ isLoading }">
        <FormulateInput
            name="name"
            type="text"
            label="Название теста"
            validation="required|max:255,length"
        />
        <FormulateInput
            name="desc"
            type="textarea"
            label="Описание теста"
            validation="max:1024,length"
        />
        <FormulateInput
            type="select"
            name="discipline"
            label="Дисциплина теста"
            :options="disciplines"
            validation="required"
        />
        <FormulateInput
            name="countQuestion"
            label="Количество вопросов в тесте"
            validation="required|number|max:200|min:1"
        />
        <FormulateInput
            type="submit"
            :disabled="isLoading"
            :label="isLoading ? 'Загрузка..' : 'Сохранить'"
        />
    </FormulateForm>
</template>

<script>
export default {
    props: {
        disciplines: {
            type: Object,
            required: true,
        },
        test: {
            type: Object,
            required: false,
        },
    },
    data() {
        return {
            formValues: {},
            id: null,
        };
    },
    methods: {
        send(data) {
            let url = "";
            if (this.id) {
                url = `/test/${this.id}`;
            } else {
                url = `/test/create`;
            }

            axios
                .post(url, data)
                .then((response) => {
                    console.log(response);
                    if (!this.id && response.data.test) {
                        this.id = response.data.test.id;
                    }

                    this.$notify({
                        title: "Добавление / редактирование теста",
                        text: response.data.message,
                        type: "success",
                    });
                })
                .catch((error) => {
                    this.$notify({
                        title: "Добавление / редактирование теста",
                        text: error.response.data.message
                            ? error.response.data.message
                            : "Не удалось обработать запрос",
                        type: "error",
                    });
                });
        },
    },
};
</script>

<style></style>

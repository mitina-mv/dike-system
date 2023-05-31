<template>
    <div class="form-wrapper formulate-questions-group">
        <FormulateForm v-model="formData" #default="{ hasErrors }">
            <FormulateInput
                name="name"
                validation="required|max:255, length"
                label="Название группы"
                help="Не более 255 символов"
            />
            <FormulateInput 
                type="submit" 
                :disabled="hasErrors"
                label="Создать"
                @click="send"
            />
        </FormulateForm>
    </div>
</template>

<script>
export default {
    data() {
        return {
            formData: {},
        }
    },

    methods: 
    {
        send()
        {
            axios.post("/group/create", this.formData)
                .then((res) => 
                {
                    this.$notify({
                        title: 'Создание группы',
                        text: res.data.message ? res.data.message : "Успешно!",
                        type: "success",
                    });
                })
                .catch((error) => {
                    this.$notify({
                        title: "Создание группы",
                        text: error.response.data.message,
                        type: "error",
                    });
                });
        }
    }
}
</script>

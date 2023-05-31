<template>
    <div class="form-wrapper formulate-questions-group">
        <FormulateForm v-model="formData" #default="{ hasErrors }">
            <FormulateInput
                name="name"
                validation="required|max:255, length"
                :label="label"
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
    props: ['label', 'url'],
    data() {
        return {
            formData: {},
        }
    },

    methods: 
    {
        send()
        {
            axios.post(this.url, this.formData)
                .then((res) => 
                {
                    this.$notify({
                        title: 'Создание',
                        text: res.data.message ? res.data.message : "Успешно!",
                        type: "success",
                    });
                })
                .catch((error) => {
                    let errorMessage = error.response.data.message;

                    if(error.response.data.errors && error.response.data.errors.code)
                        errorMessage = error.response.data.errors.code[0];

                    this.$notify({
                        title: "Создание",
                        text: errorMessage,
                        type: "error",
                    });
                });
        }
    }
}
</script>

<template>
    <div class="form-wrapper formulate-questions-group">
        <FormulateForm v-model="formData" #default="{ hasErrors }">
            <FormulateInput
                name="question_text"
                validation="required|max:510"
                label="Текст вопроса"
                help="Не более 510 символов"
            />
            <FormulateInput
                type="number"
                name="question_mark"
                validation="required|min:1"
                label="Стоимость вопроса (по умолчанию 1)"
                help="Баллы за этот вопрос"
            />
            <FormulateInput
                name="questiprivate"
                type="checkbox"
                label="Приватный вопрос"
            />
            <FormulateInput
                type="select"
                name="question_type"
                label="Тип вопроса"
                :options="types"
            />

            <FormulateInput
                type="group"
                name="answers"
                :repeatable="true"
                label="Введите ответы"
                add-label="+ Добавить ответ"
                validation="required|min:1,length|isCorrect"
                :validation-rules="{ isCorrect: isCorrectRule }"
                :validation-messages="{ isCorrect: isCorrectMessage }"
            >
                <div class="attendee">
                    <FormulateInput
                        name="text"
                        validation="required|max:255"
                        label="Текст ответа"
                        help="Не более 255 символов"
                    />
                    <FormulateInput
                        name="isCorrect"
                        type="checkbox"
                        label="Правильный"
                        :value="false"
                    />
                    <FormulateInput
                        name="isDelete"
                        type="checkbox"
                        label="Удалить"
                        :value="false"
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
            formData: {
                question_type: 'single',
                answers: [{
                    text: '',
                    isCorrect: true,
                    isDelete: false
                }]
            },
            types: {
                single: "Одиночный выбор",
                multiple: "Множественный выбор",
                text: "Текстовый ответ",
            },
        }
    },
    methods: 
    {
        send()
        {
            console.log(this.formData);
            // axios.post('/users/student', this.formData)
            // .then((res) => {
            //     this.$notify({
            //         title: "Добавление студентов",
            //         text: res.data.message ? res.data.message : "Успешно!",
            //         type: "success",
            //     });
            // })
            // .catch((error) => {
            //     this.$notify({
            //         title: "Добавление студентов",
            //         text: error.response.data.message,
            //         type: "error",
            //     });
            // });
        }, 
        countCorrectAnswers() {
            let correctAnswers = 0;

            for (let i = 0; i < this.formData.answers.length; i++) 
            {

                if (this.formData.answers[i].isCorrect == true
                && (this.formData.answers[i].isDelete == false)
                ) {
                    correctAnswers++;
                }
            }
            return correctAnswers;
        },
        isCorrectRule() {
            switch (this.formData.question_type) {
                case 'single':
                    let correctAnswers = 0;

                    for (let i = 0; i < this.formData.answers.length; i++) 
                    {

                        if (this.formData.answers[i].isCorrect == true
                        && (this.formData.answers[i].isDelete == false)
                        ) {
                            correctAnswers++;
                        }
                    }
                    
                    return correctAnswers == 1;

                case 'multiple':
                    
                    break;
                case 'text':
                    
                    break;
            
                default:
                    return false
                    break;
            }
        },
        isCorrectMessage() {

        },
    }
};
</script>

<style>
.formulate-questions-group .formulate-input-grouping {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    width: 100%;
}

.formulate-questions-group .formulate-input-element.formulate-input-element--group.formulate-input-group {
    max-width: 100%;
}
.formulate-questions-group a.formulate-input-group-repeatable-remove {
    display: none !important;
}
</style>
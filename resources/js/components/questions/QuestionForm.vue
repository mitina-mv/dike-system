<template>
    <div class="form-wrapper formulate-questions-group">
        <FormulateForm v-model="formData" #default="{ hasErrors }">
            <FormulateInput
                name="name"
                validation="required|max:510, length"
                label="Текст вопроса"
                help="Не более 510 символов"
            />
            <FormulateInput
                type="number"
                name="mark"
                validation="required|min:1"
                label="Стоимость вопроса (по умолчанию 1)"
                help="Баллы за этот вопрос"
            />
            <FormulateInput
                name="private"
                type="checkbox"
                label="Приватный вопрос"
            />
            <FormulateInput
                type="select"
                name="discipline"
                validation="required"
                label="Дисциплина"
                :options="disciplines"
            />
            <FormulateInput
                type="select"
                name="type"
                validation="required"
                label="Тип вопроса"
                :options="types"
            />

            <FormulateInput
                type="group"
                name="answers"
                :repeatable="true"
                label="Введите ответы"
                add-label="+ Добавить ответ"
                validation="required|isCorrect"
                :validation-rules="{ isCorrect: isCorrectRule }"
                :validation-messages="{ isCorrect: isCorrectMessage }"
            >
                <div class="attendee">
                    <FormulateInput
                        name="text"
                        validation="required|max:255,length"
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
                    <FormulateInput
                        type="hidden"
                        name="id"
                        value="__new"
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
    props: {
        disciplines: {
            type: Object,
            required: true,
        },
        question: { // question
            type: Object,
            required: false,
            default: null
        },
    },

    data() {
        return {
            formData: {
                type: 'single',
                mark: 1,
                private: false,
                answers: [{
                    text: '',
                    isCorrect: true,
                    isDelete: false,
                    id: '__new'
                }]
            },
            types: {
                single: "Одиночный выбор",
                multiple: "Множественный выбор",
                text: "Текстовый ответ",
            },
        }
    },

    mounted(){
        if(this.question)
        {
            this.formData = {
                name: this.question.question_text,
                mark: this.question.mark,
                private: this.question.question_private,
                discipline: this.question.discipline_id,
                type: JSON.parse(this.question.question_settings).type
            }

            if(this.question.answers){
                this.formData.answers = [];

                this.question.answers.forEach(item => {
                    this.formData.answers.push({
                        text: item.answer_name,
                        isCorrect: item.answer_status,
                        isDelete: false,
                        id: item.id
                    })
                })
            } else {
                this.formData.answers = [{
                    text: '',
                    isCorrect: true,
                    isDelete: false,
                    id: '__new'
                }]
            }
        }        
    },

    methods: 
    {
        send()
        {
            for(let i in this.formData.answers)
            {
                if(!this.formData.answers[i].hasOwnProperty('isDelete')
                    || this.formData.answers[i].isDelete == ''
                ) {
                    this.formData.answers[i].isDelete = false
                }

                if(!this.formData.answers[i].hasOwnProperty('isCorrect')
                    || this.formData.answers[i].isCorrect == ''
                ) {
                    this.formData.answers[i].isCorrect = false
                }
            }

            let url = '';
            if(this.question)
            {
                url = `/question/${this.question.id}`
            } else {
                url = `/question/create`
            }

            axios.post(url, this.formData)
                .then((res) => 
                {
                    if(!this.question){
                        this.question = res.data.question
                        this.updateAnswersCreateAfter(res.data.answers)
                    }
                    this.$notify({
                        title: 'Добавление / редактирование вопроса',
                        text: res.data.message ? res.data.message : "Успешно!",
                        type: "success",
                    });
                })
                .catch((error) => {
                    this.$notify({
                        title: "Добавление / редактирование вопроса",
                        text: error.response.data.message,
                        type: "error",
                    });
                });
        }, 
        countCorrectAnswers() {
            let correctAnswers = 0;

            for (let i = 0; i < this.formData.answers.length; i++) 
            {
                if (this.formData.answers[i].isCorrect === true
                && (this.formData.answers[i].isDelete === false 
                    || this.formData.answers[i].isDelete == "")
                ) {
                    correctAnswers++;
                }
            }
            return correctAnswers;
        },
        countDeleteAnswers() {
            let correctAnswers = 0;

            for (let i = 0; i < this.formData.answers.length; i++) 
            {
                if (this.formData.answers[i].isDelete === true) {
                    correctAnswers++;
                }
            }
            return correctAnswers;
        },
        isCorrectRule() {
            switch (this.formData.type) {
                case 'single':                    
                    return this.countCorrectAnswers() === 1;
                    break;
                case 'multiple':
                    return this.countCorrectAnswers() >= 1;
                    
                    break;
                case 'text':
                    let correctAnswers = this.countCorrectAnswers();
                    let bool = correctAnswers === (this.formData.answers.length - this.countDeleteAnswers());

                    return bool && correctAnswers != 0;
                    break;
            
                default:
                    return false
                    break;
            }
        },
        isCorrectMessage() {
            switch (this.formData.type) {
                case 'single':
                    return 'Правильный ответ должен быть только один'

                case 'multiple':
                    return 'Нужен хотя бы один правильный ответ'

                case 'text':
                    return 'Все ответы должны быть правильными'
            }
        },
        updateAnswersCreateAfter(answers){
            this.formData.answers = [];

            answers.forEach(item => {
                this.formData.answers.push({
                    text: item.answer_name,
                    isCorrect: item.answer_status,
                    isDelete: false,
                    id: item.id
                })
            })
        }
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
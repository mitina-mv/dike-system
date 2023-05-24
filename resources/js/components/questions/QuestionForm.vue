<template>
    <div>
        <div class="alert alert-danger mt-3 mb-3" role="alert" v-show="errorText">
            {{ errorText }}
        </div>
        
        <div class="question-title form-group">
            <label for="">Текст вопроса</label>
            <input
                type="text"
                class="form-control"
                id="question_text"
                aria-describedby="question_text_help"
                placeholder="Новый вопрос"
                v-model="name"
            />
            <small id="question_text_help" class="form-text text-muted"
                >Не более 510 символов</small
            >
        </div>

        <div class="form-check">
            <input
                type="checkbox"
                class="form-check-input"
                id="questiprivate"
                v-model="privateCheck"
            />
            <label class="form-check-label" for="question_private"
                >Приватный вопрос</label
            >
        </div>

        <div class="form-group">
            <label for="">Тип вопроса</label>
            <select name="type" id="question_type" v-model="type">
                <option
                    v-for="(type, index) in types"
                    :key="index"
                    :value="type.code"
                >
                    {{ type.name }}
                </option>
            </select>
        </div>

        <div class="form-group">
            <label for="question_disciplines">Дисциплины вопроса</label>
            <multiselect
                v-model="disciplinesAdd"
                :options="disciplines"
                :multiple="true"
                :taggable="true"
                label="discipline_name"
                track-by="id"
                placeholder="Дисциплины"
                name="disciplines"
                :searchable="true"
            ></multiselect>
        </div>

        <h5 class="h4">Ответы</h5>

        <div class="alert alert-warning mt-3 mb-3" role="alert" v-if="type=='text'">
            Введите все ПРАВИЛЬНЫЕ текстовые ответы
        </div>

        <div class="answer-body">
            <div
                class="answer-item"
                :class="getDeleteClass(index)"
                v-for="(answer, index) in answers"
                :key="index"
            >
                <div class="form-group">
                    <label>Текст ответа</label>
                    <input
                        type="text"
                        class="form-control"
                        :aria-describedby="'answer_text_' + index"
                        placeholder="Вариант ответа"
                        v-model="answer.text"
                    />
                    <small
                        :id="'answer_text_' + index"
                        class="form-text text-muted"
                        >Не более 255 символов</small
                    >
                </div>

                <div class="form-check">
                    <input
                        type="checkbox"
                        class="form-check-input"
                        v-model="answer.isCorrect"
                    />
                    <label class="form-check-label">Правильный</label>
                </div>

                <div class="form-check">
                    <input
                        type="checkbox"
                        class="form-check-input"
                        v-model="answer.isDelete"
                    />
                    <label class="form-check-label text-danger">Удалить</label>
                </div>
            </div>
            <button
                class="btn btn-outline-secondary mt-3 mb-3"
                @click="addAnswer()"
            >
                Добавить вариант ответа
            </button>
        </div>

        <button class="btn btn-success" @click="send()">Сохранить</button>
    </div>
</template>

<script>
import Multiselect from "vue-multiselect";

export default {
    props: {
        disciplines: {
            type: Array,
            required: true,
        },
        question: {
            type: Array,
            required: false,
        },
    },
    data() {
        return {
            name: "",
            privateCheck: false,
            type: "single",
            disciplinesAdd: [],
            errorText: null,
            types: [
                {
                    name: "Одиночный выбор",
                    code: "single",
                },
                {
                    name: "Множественный выбор",
                    code: "multiple",
                },
                {
                    name: "Текстовый ответ",
                    code: "text",
                },
            ],
            answers: [
                { text: "", isCorrect: true, isDelete: false, id: "__new" },
            ],
        };
    },
    components: { Multiselect },
    computed: {},
    methods: {
        addAnswer: function () {
            if(this.type == 'text') {
                this.answers.push({
                    text: "",
                    isCorrect: true,
                    isDelete: false,
                    id: "__new",
                });
            } else {
                this.answers.push({
                    text: "",
                    isCorrect: false,
                    isDelete: false,
                    id: "__new",
                });
            }
        },
        send() {
            this.name = this.name.replace(/\s+/g, " ");

            // проверка наличия данных
            if(!this.name || !this.disciplinesAdd
                || !this.type || !this.answers
            ) {
                this.errorText = 'Введите все обязательные поля: текст вопроса, тип, дисциплины. Проверьте ввод ответов.'
            }

            // проверка наличия правильного ответа
            let flagCorrectAnswer = false;
            let countSimpleCorrectAnswer = 0;
            this.answers.forEach((item) => {
                if(item.isCorrect == true && item.isDelete !== true)
                {
                    flagCorrectAnswer = true;
                    if(this.type == 'simple') {
                       ++countSimpleCorrectAnswer; 
                    }
                }
            })

            if(!flagCorrectAnswer) {
                this.errorText = 'Выберите хотя бы один правильный ответ среди тех, которые не удаляются'
            }
            
            if(countSimpleCorrectAnswer != 1) {
                this.errorText = 'Для одиночного выбора нужно ввести только один правильный ответ'
            }


        },
        getDeleteClass(index) {
            return this.answers[index].isDelete ? "answer-item_delete" : "";
            // return 'answer-item_delete' + index
        },
    },
};
</script>

<style scoped>
.answer-item {
    padding: 1em;
}
.answer-item:nth-child(2n) {
    background: #ebeefe;
}
.answer-item_delete {
    background: #ffdbdb !important;
}

.answer-item_delete:before {
    content: "Будет удалено!";
    color: #fff;
    font-weight: 800;
    background: var(--bs-red);
    padding: 4px 10px;
    margin-bottom: 10px;
    display: block;
}
.answer-body {
    list-style-type: none;
    counter-reset: css-counter 0;
}

.answer-body .answer-item {
    counter-increment: css-counter 1;
    position: relative;
}

.answer-body .answer-item:after {
    content: counter(css-counter);
    background: #fff;
    color: var(--bs-indigo);
    border: 2px solid var(--bs-indigo);
    border-radius: 50%;
    display: flex;
    width: 30px;
    height: 30px;
    text-align: center;
    font-weight: 700;
    position: absolute;
    align-items: center;
    justify-content: center;
    top: -5px;
    right: -14px;
}
</style>

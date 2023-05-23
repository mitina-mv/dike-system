<template>
    <div>
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

        <div class="question-title form-group">
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

        <div class="question-title form-group">
            <label for="">Дисциплины вопроса</label>
            <select name="disciplines" id="question_disciplines" v-model="disciplines">
                <option
                    v-for="(type, index) in types"
                    :key="index"
                    :value="type.code"
                >
                    {{ type.name }}
                </option>
            </select>
        </div>

        <h5>Ответы</h5>
        <div
            class="answer-item"
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
                <small :id="'answer_text_' + index" class="form-text text-muted"
                    >Не более 255 символов</small
                >
            </div>

            <div class="form-check">
                <input
                    type="checkbox"
                    class="form-check-input"
                    v-model="answer.isCorrect"
                />
                <label class="form-check-label"
                    >Правильный</label
                >
            </div>
        </div>
        <button class="btn btn-outline-secondary" @click="addAnswer()">Добавить вариант ответа</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: "",
            privateCheck: false,
            type: "single",
            disciplines: [],
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
            answers: [{ text: "", isCorrect: false }],
        };
    },
    methods: {
        addAnswer: function() {
            this.answers.push({ text: "", isCorrect: false });
        }
    }
};
</script>

<style scoped>
.answer-item{
    padding: 1em;
}
.answer-item:nth-child(2n) {
    background: #ebeefe;
}
</style>

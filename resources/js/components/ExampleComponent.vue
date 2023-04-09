<template>
    <div>
        <h2>{{ question.title }}</h2>
        <div v-if="question.type === 'single'">
            <div v-for="(choice, index) in question.choices" :key="index">
                <input
                    type="radio"
                    :name="question.title"
                    :value="choice"
                    v-model="selectedOneAnswer"
                />{{ choice }}
            </div>
        </div>
        <div v-else-if="question.type === 'multiple'">
            <div v-for="(choice, index) in question.choices" :key="index">
                <input
                    type="checkbox"
                    :name="question.title"
                    :value="choice"
                    v-model="selectedMultipleAnswers"
                />{{ choice }}
            </div>
        </div>
        <button
            @click="nextQuestion"
            v-if="currentQuestion < questions.length - 1"
        >
            Next
        </button>
        <button @click="submitAnswers" v-else>Submit</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            questions: [
                {
                    title: "What is the capital of France?",
                    type: "single",
                    answer: "Paris",
                    choices: ["Berlin", "New York", "Paris", "Beijing"],
                },
                {
                    title: "What are the colors of the Russian flag?",
                    type: "multiple",
                    answer: ["White", "Blue", "Red"],
                    choices: ["White", "Blue", "Red", "Green"],
                },
            ],
            selectedOneAnswer: "",
            selectedMultipleAnswers: [],
            currentQuestion: 0,
        };
    },
    computed: {
        question() {
            return this.questions[this.currentQuestion];
        },
    },
    methods: {
        submitAnswers() {
            //Process the submitted answers
        },
        nextQuestion() {
            this.currentQuestion++;
        },
    },
};
</script>

<style scoped>
    h2 {
        font-size: 20px;
        line-height: 1.5;
        margin-bottom: 10px;
        font-weight: bold;
    }

    input[type="checkbox"],
    input[type="radio"] {
        margin-right: 10px;
        margin-bottom: 10px;
    }
</style>

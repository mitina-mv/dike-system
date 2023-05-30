<template>
    <div>
        <survey :survey="survey" />
        
        <div v-if="!survey.isCompleted" class="navigation-block d-flex">
            <div>
                <span class="navigation-text">{{progressText()}}</span>
                <button v-if="!survey.isFirstPage"
                        @click="survey.prevPage()"
                        class="navigation-button">
                    Назад
                </button>
                <button v-if="!survey.isLastPage"
                        @click="survey.nextPage()"
                        class="navigation-button">
                    Вперед
                </button>
                <button v-if="survey.isLastPage"
                        @click="survey.completeLastPage()"
                        class="navigation-button">
                    Завершить
                </button>
            </div>
            <div>
                <span class="navigation-text">Быстрый переход</span>
                <select class="navigation-page-selector" v-model="survey.currentPageNo"
                        @change="changeCurrentPage($event)">
                    <option v-for="(item, index) in survey.visiblePages"
                            :key="index" :value="index">
                        {{"Вопрос " + (index + 1)}}
                    </option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
import "survey-core/defaultV2.min.css";
import { StylesManager, Model } from "survey-core";
import { Survey } from "survey-vue-ui";

StylesManager.applyTheme("defaultV2");

export default {
    props: ['testing'],
    components: {
        Survey,
    },
    data() {
        const survey = new Model(Object.assign(this.testing, {
            pageNextText: "Далее",
            pagePrevText: "Назад",
            previewText: "Проверка",
            completeText: "Завершить тестирование",
            completedHtml: "<h3>Тестирование завершено! Оценка отобразится на странице тестов.</h3> <a href='/student-test' class='sd-btn sd-btn--action'>Страница тестов</a>",
            showPreviewBeforeComplete: "showAnsweredQuestions",
        }));

        survey.onComplete.add((sender, options) => {
            console.log(JSON.stringify(sender.data, null, 3));
        });

        return {
            surveyConfig: null,
            survey: survey,
            changeCurrentPage: (event) => {
                survey.currentPageNo = Number(event.target.value);
            },
            progressText: () => {
                return "Вопрос " + (survey.currentPageNo + 1) + " из " + survey.visiblePages.length;
            }
        };
    },
    mounted() {
        this.surveyConfig = {
            title: this.testing.title,
            pages: this.testing.pages,
            pageNextText: "Далее"
        }
    },
    methods: {
        alertResults(sender) {
            console.log(JSON.stringify(sender.data, null, 3));
        },
    },
};
</script>

<style scoped>
.navigation-block {
    margin: 10px;
}
.navigation-text {
    padding: 8px;
}
.navigation-button {
    background-color: transparent;
    padding: 8px;
    margin: 6px 2px;
    border: 2px solid #19b394;
    border-radius: 5px;
    -webkit-transition: all 0.15s ease-in-out;
    transition: all 0.15s ease-in-out;
    color: #00d7c3;
}
.navigation-button:hover {
    box-shadow: 0 0 2px 0 #19b394 inset, 0 0 4px 2px #19b394;
}
.navigation-page-selector {
    width: 150px;
    box-sizing: border-box;
    border-radius: 2px;
    height: 34px;
    line-height: 34px;
    background: #fff;
    outline: 1px solid #d4d4d4;
    text-align: left;
    border: none;
    padding: 0 5px;
}
.navigation-page-selector:focus {
    outline: 1px solid #1ab394;
}
.navigation-block.d-flex {
    align-items: center;
    justify-content: space-around;
}
</style>

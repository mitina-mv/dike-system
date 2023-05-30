<template>
    <span>
        <div v-if="!survey.isCompleted" class="navigation-block">
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
                        {{"Страница " + (index + 1)}}
                    </option>
                </select>
            </div>
        </div>
        <survey :survey="survey" />
    </span>
</template>

<script>
import "survey-core/defaultV2.min.css";
import { StylesManager, Model } from "survey-core";
import { Survey } from "survey-vue-ui";

StylesManager.applyTheme("defaultV2");

const surveyJson = { 
    title: "Software developer survey.",
    pages: [
      {
        "title": "What operating system do you use?",
        "elements": [
          {
            "type": "checkbox",
            "name": "opSystem",
            "title": "OS",
            "showOtherItem": true,
            "isRequired": true,
            "choices": [ "Windows", "Linux", "Macintosh OSX" ]
          }
        ]
      },
      {
        "title": "What language(s) are you currently using?",
        "elements": [
          {
            "type": "checkbox",
            "name": "langs",
            "title": "Please select from the list",
            "colCount": 4,
            "isRequired": true,
            "choices": [
              "Javascript",
              "Java",
              "Python",
              "CSS",
              "PHP",
              "Ruby",
              "C++",
              "C",
              "Shell",
              "C#",
              "Objective-C",
              "R",
              "VimL",
              "Go",
              "Perl",
            ]
          }
        ]
      },
      {
        "title": "Please enter your name and e-mail",
        "elements": [
          {
            "type": "text",
            "name": "name",
            "title": "Name:"
          },
          {
            "type": "text",
            "name": "email",
            "title": "Your e-mail"
          }
        ]
      }],
    pageNextText: "Далее",
    pagePrevText: "Назад",
    previewText: "Проверка",
    completeText: "Завершить тестирование",
    completedHtml: "<h3>Тестирование завершено! Оценка отобразится на странице тестов.</h3>",
    showPreviewBeforeComplete: "showAnsweredQuestions"
};

export default {
    components: {
        Survey,
    },
    data() {
        const survey = new Model(surveyJson);
        survey.onComplete.add((sender, options) => {
            console.log(JSON.stringify(sender.data, null, 3));
        });
        return {
            survey: survey,
            changeCurrentPage: (event) => {
                survey.currentPageNo = Number(event.target.value);
            },
            progressText: () => {
                return "Вопрос " + (survey.currentPageNo + 1) + " из " + survey.visiblePages.length;
            }
        };
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
</style>

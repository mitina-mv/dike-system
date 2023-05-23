<template>
    <div>
        <div class="mb-3 mt-3">
            <button
                v-for="disc in discipline"
                :key="disc.id"
                @click="changeDiscipline(disc.id)"
                :class="
                    currentDiscipline == disc.id
                        ? 'btn-secondary'
                        : 'btn-outline-secondary'
                "
                class="group-btn btn me-2"
            >
                {{ disc.discipline_name }}
            </button>

            <a href="/question/create" class="btn btn-primary">+ Добавить дисциплину</a>
        </div>

        <VueTabulator v-model="questions[currentDiscipline]" :options="options" />
    </div>
</template>

<script>
import { functions } from 'lodash';
export default {
    props: ["questions", 'discipline'],
    data() {
        return {
            currentDiscipline: 1,
            url: '/question/',
            options: {
                columns: [
                    {
                        title: 'Текст вопроса',
                        field: 'question_text',
                        sorter: 'string',
                        headerFilter:true,
                        headerFilterPlaceholder: "Поиск по вопросу"
                    },{
                        title: 'Привaтность',
                        field: 'question_private',
                        formatter:"tickCross",
                        width: 130
                    }, 
                    {
                        formatter: function(cell) {
                            let data = cell.getRow().getData();
                            return `<a
                                href="/question/${data.id}"
                                class="btn btn-outline-success"
                            >
                                Редактировать
                            </a>`
                        },
                        hozAlign:"center",
                        headerSort:false,
                        width: 150
                    },
                    {
                        formatter: (cell) => {
                            let data = cell.getRow().getData();
                            return `<button
                                class="btn btn-outline-danger ml-2"
                            >
                                Удалить
                            </button>`
                        },
                        hozAlign:"center",
                        headerSort:false,
                        width: 100,
                        cellClick: (e, cell) => {
                            let data = cell.getRow().getData();

                            axios.delete(`/question/${data.id}`)
                                .then(res => {
                                    this.$notify({
                                        title: 'Удаление вопроса',
                                        text: res.data.message,
                                        type: 'success',
                                    });
                                    cell.getRow().delete();
                                })
                                .catch(error => {
                                    this.$notify({
                                        title: 'Удаление вопроса',
                                        text: error.response.data.message ? error.response.data.message : "Не удалось обработать запрос",
                                        type: 'error',
                                    });
                                })
                        }
                    },
                ],
                layout:"fitColumns",
                height:"auto",
            },
            // columnNames: [
            //     {
            //         name: "Текст вопроса",
            //         code: "question_text",
            //         type: 'text'
            //     },
            //     {
            //         name: "Привaтность",
            //         code: "question_private",
            //         type: 'checkbox'
            //     },
            //     {
            //         name: "Действия",
            //         code: "buttons",
            //     },
            // ],
            currentSortColumn: "",
            sortAscending: true,
        };
    },
    methods: {
        changeDiscipline(index) {
            this.currentDiscipline = index;
        },
    },
};
</script>

<style lang='scss'>
@import "~vue-tabulator/dist/scss/tabulator_simple.scss";
</style>

<template>
    <div>
        <div class="years-block" v-if="years">
            <div
                class="year-button btn"
                :class="
                    year.year == curYear
                        ? 'btn-secondary'
                        : 'btn-outline-secondary'
                "
                v-for="(year, index) in years"
                :key="index"
                @click="getTestList(year.year)"
            >
                {{ year.year }} ({{ year.count_test }})
            </div>
        </div>
        <div class="" v-else>Вы пока не назначили ни один тест</div>

        <a href="/assignment/create" class="btn btn-primary"
            >Назначить тестирование
        </a>

        <VueTabulator v-model="testList" :options="options" />

        <modal name="my-first-modal">

            <div class="modal-head">
                <h5 class="h5">Студенты, которым назначен тест</h5>
                <button @click="closeModal" class="btn-close"></button>
            </div>

            <div class="modal-body">
                <div class="groups-list">
                    <div
                        class="group-item"
                        v-for="(item, index) in usersList"
                        :key="index"
                    >
                        <div class="group-name">{{ item.name }}</div>
                        <div class="group__user-list">
                            <div
                                class="group__user-item"
                                v-for="(user, ind) in item.users"
                                :key="ind"
                            >
                                <b class="user-lastname">{{ user.user_lastname }}</b> {{ user.user_firstname }}  {{ user.user_patronymic }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
export default {
    props: {
        years: {
            require: true,
        },
        yearstart: {
            require: false,
        },
    },
    data() {
        return {
            testList: [],
            usersList: [],
            curYear: this.yearstart,
            url: "/assignment",
            options: {
                columns: [
                    {
                        title: "Название теста",
                        field: "test_name",
                        sorter: "string",
                        headerFilter: true,
                        headerFilterPlaceholder: "Поиск по названию",
                    },
                    {
                        title: "Дата / время тестирования",
                        field: "format-date",
                        sorter: "date",
                        formatter: "date",
                        width: 200,
                    },
                    {
                        title: "Группы студентов",
                        field: "groups",
                        sorter: "text",
                        width: 200,
                    },
                    {
                        formatter: (cell) => {
                            return `<div
                                class="btn btn-outline-primary"
                            >
                                Список студентов
                            </div>`;
                        },
                        hozAlign: "center",
                        headerSort: false,
                        width: 180,
                        cellClick: (e, cell) => {
                            let data = cell.getRow().getData();

                            this.getUserList(data);
                        },
                    },
                    {
                        formatter: (cell) => {
                            return `<div
                                class="btn btn-outline-danger"
                            >
                                Удалить
                            </div>`;
                        },
                        hozAlign: "center",
                        headerSort: false,
                        width: 150,
                        cellClick: (e, cell) => {
                            let data = cell.getRow().getData();

                            axios
                                .delete(`${this.url}/${data.test_id}/${data.testlog_date}`)
                                .then((res) => {
                                    this.$notify({
                                        title: "Удаление назначения",
                                        text: "Успех!",
                                        type: "success",
                                    });
                                    cell.getRow().delete();
                                })
                                .catch((error) => {
                                    this.$notify({
                                        title: "Удаление назначения",
                                        text: "Не удалось обработать запрос",
                                        type: "error",
                                    });
                                });
                        },
                    },
                ],
                layout: "fitColumns",
                height: "auto",
            },
        };
    },
    mounted() {
        if (this.years) {
            this.getTestList(this.curYear);
        }
    },
    methods: {
        getTestList(year) {
            axios
                .get("/assignment/" + year)
                .then((response) => {
                    this.testList = response.data;
                    this.curYear = year;
                })
                .catch((error) => {
                    this.$notify({
                        title: "Получение списка тестов",
                        text: error.response.data.message,
                        type: "error",
                    });
                });
        },
        getUserList(data) {
            axios
                .get(`${this.url}/${data.test_id}/${data.testlog_date}`)
                .then((res) => {
                    this.usersList = res.data;
                    this.$modal.show("my-first-modal");
                })
                .catch((error) => {
                    this.$notify({
                        title: "Получение списка студентов",
                        text: "Не удалось обработать запрос",
                        type: "error",
                    });
                });
        },
        closeModal() {
            this.$modal.hide("my-first-modal");
        }
    },
};
</script>

<style>
.modal-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-bottom: 10px;
    border-bottom: 1px solid var(--bs-border-color);
    margin-bottom: 10px;
}

.vm--modal {
    padding: 20px;
}

.group-name {
    padding: 8px;
    background: #e1ffe2;
    font-weight: 700;
}

.group__user-item {
    padding: 6px;
    counter-increment: css-counter 1;
    padding-left: 30px;
}

.group__user-list {
    counter-reset: css-counter 0;
    list-style-type: none;
}

.group__user-item:after {
    content: counter(css-counter);
    left: 10px;
    position: absolute;
    font-weight: 700;
    color: var(--bs-success);
}

b.user-lastname {
    color: var(--bs-success);
}
</style>

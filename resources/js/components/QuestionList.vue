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
                {{ disc.name }}
            </button>

            <a href="/question/create" class="btn btn-primary">+ Добавить дисциплину</a>
        </div>

        <table-filter
            :array="questions[currentDiscipline]"
            :url="'/question/'"
            :addButtons="true"
            :columns="columnNames"
        ></table-filter>
    </div>
</template>

<script>
import TableFilter from './TableFilter.vue';

export default {
    props: ["questions", 'discipline'],
    data() {
        return {
            currentDiscipline: 1,
            columnNames: [
                {
                    name: "Текст вопроса",
                    code: "question_text",
                    type: 'text'
                },
                {
                    name: "Привaтность",
                    code: "question_private",
                    type: 'checkbox'
                },
                {
                    name: "Действия",
                    code: "buttons",
                },
            ],
            currentSortColumn: "",
            sortAscending: true,
        };
    },
    components: { TableFilter },
    computed: {
        sortIcon() {
            return this.sortAscending ? "fas fa-arrow-up" : "fas fa-arrow-down";
        },
    },
    methods: {
        changeDiscipline(index) {
            this.currentDiscipline = index;
        },
    },
};
</script>

<style scoped>
thead.thead-dark {
    background: #424242;
    color: #fff;
}
</style>

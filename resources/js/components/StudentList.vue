<template>
    <div>
        <div class="mb-3 mt-3">
            <button
                v-for="(group, index) in groups"
                :key="group.id"
                @click="changeGroup(index)"
                :class="
                    currentGroup == index
                        ? 'btn-secondary'
                        : 'btn-outline-secondary'
                "
                class="group-btn btn me-2"
            >
                {{ group.name }}
            </button>
        </div>

        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th @click="sortBy('user_lastname')" scope="col">
                        {{ columnNames.name }}
                        <i
                            v-show="currentSortColumn === 'user_lastname'"
                            :class="sortIcon"
                        ></i>
                    </th>

                    <th @click="sortBy('user_email')" scope="col">
                        {{ columnNames.email }}
                        <i
                            v-show="currentSortColumn === 'user_email'"
                            :class="sortIcon"
                        ></i>
                    </th>

                    <th scope="col">{{ columnNames.buttons }}</th>
                </tr>
            </thead>

            <tbody>
                <tr
                    v-for="student in groups[currentGroup].students"
                    :key="student.id"
                >
                    <td>
                        {{ student.user_lastname }}
                        {{ student.user_firstname }}
                        {{ student.user_patronymic }}
                    </td>

                    <td>{{ student.user_email }}</td>

                    <td>
                        <a
                            :href="'/users/student/' + student.id"
                            @click="editStudent(student)"
                            class="btn btn-outline-success"
                        >
                            Редактировать
                        </a>

                        <button
                            @click="deleteStudent(student)"
                            class="btn btn-outline-danger ml-2"
                        >
                            Удалить
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
// import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

export default {
    props: ["groups"],
    data() {
        return {
            currentGroup: 0,
            columnNames: {
                name: "ФИО",
                email: "Email",
                buttons: "Действия",
            },
            currentSortColumn: "",
            sortAscending: true,
        };
    },
    // components: { FontAwesomeIcon },
    computed: {
        sortIcon() {
            return this.sortAscending ? "fas fa-arrow-up" : "fas fa-arrow-down";
        },
    },
    methods: {
        changeGroup(index) {
            this.currentGroup = index;
        },
        editStudent(student) {
            // Реализация функции редактирования студента
        },
        deleteStudent(student) {
            // Реализация функции удаления студента
        },
        sortBy(column) {
            if (column === this.currentSortColumn) {
                this.sortAscending = !this.sortAscending;
            } else {
                this.sortAscending = true;
                this.currentSortColumn = column;
            }

            const sortOrder = this.sortAscending ? 1 : -1;

            this.groups[this.currentGroup].students.sort((a, b) => {
                if (a[column] > b[column]) return sortOrder;
                if (a[column] < b[column]) return -sortOrder;
                return 0;
            });
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

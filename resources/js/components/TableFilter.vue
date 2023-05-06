<template>
    <div>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th
                        v-for="(column, index) in columns"
                        :key="index"
                        @click="sortBy(column.code)"
                        scope="col"
                    >
                        {{ column.name }}
                        <i
                            v-show="currentSortColumn === column.code"
                            :class="sortIcon"
                        ></i>
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr
                    v-for="item in array"
                    :key="item.id"
                    :id="`tr-${item.id}`"
                >
                    <td v-for="column in columns" :key="column.code">
                        <span v-if="column.code == 'user_firstname'">
                            {{ item.user_lastname }}
                            {{ item.user_firstname }}
                            {{ item.user_patronymic }}                        
                        </span>
                        <div v-else-if="column.code == 'buttons'">
                            <a
                                :href="url + item.id"
                                class="btn btn-outline-success"
                            >
                                Редактировать
                            </a>

                            <button
                                @click="deleteItem(item.id)"
                                class="btn btn-outline-danger ml-2"
                            >
                                Удалить
                            </button>
                        </div>
                        <span v-else>{{ item[column.code] }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle) return true;
    }
    return false;
}

export default {
    props: ["url", 'array', 'columns', 'addButtons'],
    data() {
        return {
            currentSortColumn: "",
            sortAscending: true,
            sortingColumns: ['user_firstname', 'user_email']
        };
    },
    computed: {
        sortIcon() {
            return this.sortAscending ? "fas fa-arrow-up" : "fas fa-arrow-down";
        },
    },
    methods: {
        sortBy(column) {
            if(!inArray(column, this.sortingColumns)) return 0;

            if (column === this.currentSortColumn) {
                this.sortAscending = !this.sortAscending;
            } else {
                this.sortAscending = true;
                this.currentSortColumn = column;
            }

            const sortOrder = this.sortAscending ? 1 : -1;

            this.array.sort((a, b) => {
                if (a[column] > b[column]) return sortOrder;
                if (a[column] < b[column]) return -sortOrder;
                return 0;
            });
        },
        deleteItem(id) {
            axios.delete(`/users/${id}`)
                .then(res => {
                    this.$notify({
                        title: 'Удаление пользователя',
                        text: res.data.message,
                        type: 'success',
                    });
                    let tr = document.querySelector(`#tr-${id}`);
                    tr.remove();
                })
                .catch(error => {
                    this.$notify({
                        title: 'Удаление пользователя',
                        text: error.response.data.message,
                        type: 'error',
                    });
                })
        },
    }

}
</script>

<style scoped>
thead.thead-dark {
    background: #424242;
    color: #fff;
}
</style>

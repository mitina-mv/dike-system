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

            <a :href="addgroupurl" class="btn btn-primary">+</a>
        </div>

        <table-filter
            :array="groups[currentGroup].students"
            :url="'/user/'"
            :addButtons="true"
            :columns="columnNames"
        ></table-filter>
    </div>
</template>

<script>
import TableFilter from './TableFilter.vue';

export default {
    props: ["groups", 'addgroupurl'],
    data() {
        return {
            currentGroup: 0,
            columnNames: [
                {
                    name: "ФИО",
                    code: "user_firstname",
                },
                {
                    name: "Email",
                    code: "user_email",
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
        changeGroup(index) {
            this.currentGroup = index;
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

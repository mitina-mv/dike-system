<script>
import Tabulator from 'vue-tabulator';
// import { TabulatorFull as Tabulator } from "tabulator-tables"; //import Tabulator library

export default {
    data() {
        return {
            tabulator: null, //variable to hold your table
            tableData: [], //data for table to display
        };
    },
    mounted() {
        //instantiate Tabulator when element is mounted
        this.tabulator = new Tabulator(this.$refs.table, {
            data: this.tableData, //link data to table
            reactiveData: true, //enable data reactivity
            columns: [], //define table columns
        });
    },
};
</script>

<template>
    <div ref="table"></div>
</template>

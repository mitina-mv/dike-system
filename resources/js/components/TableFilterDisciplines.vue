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

            <a href="/discipline/" class="btn btn-primary">+ Добавить дисциплину</a>
        </div>
        <a :href="url + '/create'" class="btn btn-success">+ Создать</a>

        <VueTabulator v-model="tabledata[currentDiscipline]" :options="options" />
    </div>
</template>

<script>
export default {
    props: ['discipline', 'tabledata', 'url', 'columns', 'addactions'],
    data() {
        return {
            // TODO фу кака
            currentDiscipline: this.discipline[Object.keys(this.discipline)[0]].id,
            options: {
                columns: this.columns,
                layout:"fitColumns",
                height:"auto",
            }
        }
    },
    mounted(){
        if(this.addactions)
        {
            this.columns.push({
                formatter: (cell) => {
                    let data = cell.getRow().getData();
                    return `<a
                        href="${this.url}/${data.id}"
                        class="btn btn-outline-success"
                    >
                        Редактировать
                    </a>`
                },
                hozAlign:"center",
                headerSort:false,
                width: 150
            });

            this.columns.push({
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

                    axios.delete(`${this.url}/${data.id}`)
                        .then(res => {
                            this.$notify({
                                title: 'Удаление',
                                text: res.data.message,
                                type: 'success',
                            });
                            cell.getRow().delete();
                        })
                        .catch(error => {
                            this.$notify({
                                title: 'Удаление',
                                text: error.response.data.message ? error.response.data.message : "Не удалось обработать запрос",
                                type: 'error',
                            });
                        })
                }
            });
        }
    },
    methods: {
        changeDiscipline(index) {
            this.currentDiscipline = index;
        },
    }
}
</script>

<style scoped>

</style>
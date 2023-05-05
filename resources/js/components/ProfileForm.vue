<template>
    <div>
        <!-- <div class="d-fles">
            <input
                v-model="userData.user_lastname"
                placeholder="Фамилия"
                :name="'items[' + index + '][lastname]'"
                class="form-control"
            />
            <input
                v-model="userData.user_firstname"
                placeholder="Имя"
                :name="'items[' + index + '][firstname]'"
                class="form-control"
            />
            <input
                v-model="userData.user_patronymic"
                placeholder="Отчество"
                :name="'items[' + index + '][patronymic]'"
                class="form-control"
            />
            <input
                v-model="userData.user_email"
                placeholder="Email"
                :name="'items[' + index + '][user_email]'"
                class="form-control"
            />
        </div>

        <div>
            <label class="typo__label">Single select</label>
            <multiselect
                v-model="value"
                :options="options"
                :searchable="false"
                :close-on-select="false"
                :show-labels="false"
                placeholder="Pick a value"
            ></multiselect>
        </div> -->

        <div class="ddd" @click="log()">yf;vb</div>
    </div>
</template>

<script>
import Multiselect from "vue-multiselect";

export default {
    props: ["userData", "groups", "role", "url"],

    components: { Multiselect },

    data() {
        return {};
    },

    computed: {
        log() {
            console.log(this.userData);
            console.log(this.groups);
            console.log(this.role);

        }
    },

    methods: {
        sendData(event) {
            event.preventDefault();
            console.log(this.userData);
            // axios
            //     .post(url + this.userData.id, { items: this.userData })
            //     .then(function (response) {
            //         console.log(response);
            //     })
            //     .catch(function (error) {
            //         console.log(error);
            //     });
        },
    },
};
</script>

<style></style>

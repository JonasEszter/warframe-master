import fetchData from "../js/fetch.js";

const vue = Vue.createApp({
    data() {
        return {
            sets:[]
        }
    },
    methods: {
        async getSets() {
            const sets = await fetchData("/sets", "GET", "application/json")
            .then((response) => response.json());
            this.sets = sets;
        }
    },
    mounted() {
        this.getSets();
    }
}).mount("#sets-holder");
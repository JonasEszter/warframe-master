import fetchData from "../js/fetch.js";

const vue = Vue.createApp({
    data() {
        return {
            warframes:[]
        }
    },
    methods: {
        async getCharacters() {
            const warframes = await fetchData("/warframes", "GET", "application/json")
            .then((response) => response.json());
            this.warframes = warframes;
        }
    },
    mounted() {
        this.getCharacters();
    }
}).mount("#characters-holder");
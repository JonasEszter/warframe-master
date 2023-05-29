import fetchData from "../js/fetch.js";

const vue = Vue.createApp({
    data() {
        return {
            news:[]
        }
    },
    methods: {
        async getNews() {
            const news = await fetchData("/news", "GET", "application/json")
            .then((response) => response.json());
            this.news = news;
            console.log(news);
        }
        
    },
    mounted() {
        this.getNews();
    }
}).mount("#news-holder");
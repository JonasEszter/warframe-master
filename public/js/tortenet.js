import fetchData from "../js/fetch.js";
const vue = Vue.createApp({
    data() {
        return {
            dates: [
                {id: 1, name: "Orokin előtti korszak"}, 
                {id: 2, name: "Orokin korszak"}, 
                {id: 3, name: "Az összeomlás"}, 
                {id: 4, name: "Ébredés után"}
            ],
            isSelected: 0,
            width:'0%',
            left:'0%',
            history:[]
          }
    },
    computed: {
        computedWidth: function () {
          return this.width;
        },
        computedLeft: function () {
            return this.left;
          }
      },
    methods: {
        select(id) {
            if(this.isSelected !== id) {
                this.isSelected = id;
            }
            switch (id) {
                case 1:
                    this.width='25%';
                    this.left='0%';
                  break;
                case 2:
                    this.width='25%';
                    this.left='25%';
                    break;
                case 3:
                    this.width='25%';
                    this.left='50%';
                    break;
                case 4:
                    this.width='25%';
                    this.left='75%';
                    break;
                default:
                  console.log("Valamit elszúrtam de nagyon");
              }
          },
        async getHistory() {
            const history = await fetchData("/history", "GET", "application/json")
            .then((response) => response.json());
            this.history = history;
        }
    },
    mounted() {
        this.getHistory();
    }
}).mount("#tortenet-holder");
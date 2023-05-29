const vue = Vue.createApp({
    data() {
        return {
            isSelected: false,
            isSelected2: false,
          }
    },
    methods: {
        select(){
            this.isSelected = !this.isSelected;
            this.isSelected2 = false;
        },
        select2(){
            this.isSelected2 = !this.isSelected;
            this.isSelected = false;
        }
    }
}).mount("#container-palya");
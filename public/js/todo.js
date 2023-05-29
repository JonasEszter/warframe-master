import fetchData from "./fetch.js";

const vue = Vue.createApp({
    data() {
        return {
            progressData:[],
            progressChecks:[],
            userProgress:[],
            nextLevel:false
        }
    },
    methods: {
        async getProgress() {
            this.progressData = await fetchData(`/progress`, "GET", "application/json")
            .then((response) => response.json());
        
            this.progressData.forEach((data)=> {
                this.userProgress.push({
                    id:data.ItemID,
                    checked:data.ProgressID != null
                });
            });

            this.checkAllChecked();
        },
        checkAllChecked() {
            this.nextLevel = this.userProgress.every((data)=> {
                return data.checked != false;
            });
        },
        checkProgress(ev) {
            const itemID = parseInt(ev.target.getAttribute("itemid"));
            const checked = ev.target.checked;

            const index = this.userProgress.findIndex((data)=> {
                return data.id === itemID;
            });

            this.userProgress[index].checked = checked;

            this.checkAllChecked();

            this.sendUserProgres(itemID, checked);
        },
        async sendUserProgres(itemID, checked) {
            try {
                await fetchData('/progress', 'PUT', 'application/json', { itemID, checked });
              } catch (error) {
                console.error('Hiba történt:', error);
              }
        },
        goToNextLevel() {
            location.reload();
        }
    },
    mounted() {
        this.getProgress();

        const interval = setInterval(()=> {
            this.progressChecks = document.querySelectorAll(".progress-check");
            clearInterval(interval);
        }, 250);
        
    }
}).mount("#app");
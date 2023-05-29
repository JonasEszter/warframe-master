import fetchData from "./fetch.js";

const vue = Vue.createApp({
    data() {
        return {
            warframe:{},
            setData:[],
            effectTypes:{},
            polarities:[],
            mods:[],
            polarityHtml:"",
            capacityTD:null,
            cards:null,
            cardHolders:null,
            capacity:30,
            states:[],
            modifyBtn:true
        }
    },
    methods: {
        collectSetData() {
            const polaritySelects = document.querySelectorAll(".polarity-select");
            const modLevelSelects = document.querySelectorAll(".mod-level");
            const cardHolders = document.querySelectorAll(".card-holder");
            const characterID = this.getWarframeID();

            const modObjects = [];

            polaritySelects.forEach((ps, i)=> {
                const modLevel = modLevelSelects[i].value;
                const holderChildren = cardHolders[i].childNodes;
                const polarity = ps.value;
                let modID = 0;
                
                if(holderChildren.length > 0) {
                    modID = holderChildren[0].getAttribute("modid");
                }

                const modObject = {
                    place:i,
                    modLevel:modLevel,
                    polarity:polarity,
                    modID:modID
                };

                modObjects.push(modObject);
            });

            const obj = {
                characterID:characterID,
                setName:this.$refs.buildName.value,
                modObjects:modObjects
            };

            return obj;
        },
        async saveSet() {
            const obj = this.collectSetData();
            const warframeID = this.getWarframeID();
            try {
                const response = await fetchData('/set', 'POST', 'application/json', obj);
                const setID = await response.json();
                location.replace(`/warframe/${warframeID}/${setID}`);
            } catch (error) {
                console.log(err);
            }
        },

        async modifySet() {
            const obj = this.collectSetData();
            obj.setID = this.getSetID();

            try {
                const response = await fetchData(`/set/${obj.setID}`, 'PUT', 'application/json', obj);
                location.reload();
              } catch (error) {
                console.error('Hiba történt:', error);
              }
        },
        async deleteSet() {
            const setID = this.getSetID();

            try {
                const response = await fetchData('/delete_set', 'DELETE', 'application/json', { setID });
                location.replace('/osszeallitasok');
              } catch (error) {
                console.error('Hiba történt:', error);
              }
        },
        async getSetData() {
            const setID = this.getSetID();

            if(setID == undefined)
                return;
            
            this.setData = await fetchData(`/set?setID=${setID}`, "GET", "application/json")
            .then((response) => response.json());
            this.$refs.buildName.value = this.setData[0][0].SetName;
            
            this.modifyBtn = this.setData[0][0].UserID == this.setData[2];

            this.setData[1].forEach((set)=> {
                this.cards.forEach((card)=> {
                    const img = card.childNodes[0];
                    if(img !== undefined) {
                        const modID = parseInt(img.getAttribute("modid"));
                        const polaritySelect = document.querySelector(`#polarity-select${set.Place}`);
                        polaritySelect.value = set.PolarityID;

                        if(modID === parseInt(set.ModID)) {
                            const holder = document.querySelector(`#holder${set.Place}`);
                            holder.appendChild(img);
                            const modType = holder.getAttribute("modtype");
                            const baseDrain = parseInt(img.getAttribute("basedrain"));
                            //itt
                            const capacityMultiplier = this.getCapacityMultiplier(polaritySelect, img);
                            this.changeEffectValues(set.ModID, modType, baseDrain, set.ModLevel, capacityMultiplier);
                        }
                    }
                });
            });
        },
        getWarframeID() {
            const hrefArray = window.location.pathname.split("/");
            return parseInt(hrefArray[2]);
        },
        getSetID() {
            const hrefArray = window.location.pathname.split("/");
            return parseInt(hrefArray[3]);
        },
        async getCharacterData() {
            try {
                const characterID = this.getWarframeID();
                this.warframe = await fetchData(`/character/${characterID}`, "GET", "application/json")
                .then((response) => response.json());
                this.warframe = JSON.parse(this.warframe);

                this.states.push({
                    capacity:30,
                    energy:this.warframe.CharPower,
                    health:this.warframe.Health,
                    shield:this.warframe.Shield,
                    speed:this.warframe.Speed,
                    armor:this.warframe.Armor
                });
            } catch(err) {
                console.log(err);
            }
        },
        async getEffectTypes() {
            this.effectTypes = await fetchData("/effect_types", "GET", "application/json")
            .then((response) => response.json());
        },
        async getPolarities() {
            this.polarities = await fetchData("/polarities", "GET", "application/json")
            .then((response) => response.json());
            this.polarityHtml = this.makePolarityHTML();
        },
        async getMods() {
            const characterID = this.getWarframeID();
            this.mods = await fetchData(`/mods/${characterID}`, "GET", "application/json")
            .then((response) => response.json());
        },
        async getEffectTypesByMod(modID) {
            return await fetchData(`/effect_types_by_mod/${modID}`,
            "GET", "application/json");
        },
        async getMaxModLevel(modID) {
            return await fetchData(`/get_max_mod_level?modID=${modID}`, 
            "GET", "application/json");
        },
        makePolarityHTML() {
            let select = "<select>";

            this.polarities.forEach((p)=> {
                select += `<option value="${p.TypeID}">${p.TypeName}</option>`;
            });

            select += "</select>";

            let html = `<div>
                ${select}
                <div id="holder" class="bg-info text-center mb-1 box card-holder"
                modtype="aura"
                style="width:220px;height:312px;padding:5px;"></div>
            </div>`;

            return html;
        },

        allowDrop(ev) {
            ev.preventDefault();
        },
        drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        },
        makeEvents() {
            this.cards.forEach((card)=> {
                card.addEventListener("drop", this.drop);
                card.addEventListener("dragover", this.allowDrop);
                const img = card.querySelector("img");
                img.draggable = true;
                img.addEventListener("dragstart", this.drag);
            });
            
            this.cardHolders.forEach((ch)=> {
                ch.addEventListener("drop", this.drop);
                ch.addEventListener("dragover", this.allowDrop);
            });
        },
        async changeEffectValues(modID, modType, baseDrain, capacityMultiplier) {
            const etData = await this.getEffectTypesByMod(modID)
            .then((response) => response.json());

            etData.forEach((et)=> {
                const td = document.querySelector(`#property${et.EffectType}`);

                switch(et.effectTypes) {
                    case 17:
                        td.innerText = 150;
                        break;
                    case 18:
                        td.innerText = 100;
                        break;
                }

                if(td) {
                    let effectValue = parseFloat(td.innerText);

                    if(modType != "card-holder") {
                        let newEffectValue = effectValue * (1+et.EffectValue/100);
                        td.innerText = Math.round(newEffectValue*100)/100;
                    } else {
                        let newEffectValue = effectValue / (1+et.EffectValue/100);
                        td.innerText = Math.round(newEffectValue*100)/100;
                    }
                }
            });
    
            if(modType != "card-holder") {
                const product = Math.round(baseDrain * capacityMultiplier);
                if(this.capacity - product > 0) {
                    this.capacity -= product;
                    this.capacityTD.innerText = this.capacity;
                } else {
                    alert("Nincs elég kapacitás!");
                }
            } else {
                this.capacity += Math.round(baseDrain * capacityMultiplier);
                this.capacityTD.innerText = this.capacity;
            }
        },
        getCapacityMultiplier(polaritySelect, img) {
            const backMultiplier = parseFloat(img.getAttribute("multiplier"));
            const polarity = parseInt(img.getAttribute("polarity"));
            const compatName = img.getAttribute("compatname");
            let capacityMultiplier = 1;

            if(!isNaN(backMultiplier)) {
                capacityMultiplier = backMultiplier;
            }

            if(polaritySelect) {
                const selectValue = parseInt(polaritySelect.value);

                if(selectValue == polarity && selectValue != 0) {
                    if(compatName != "AURA")
                        capacityMultiplier = 0.5;
                    else 
                        capacityMultiplier = 2;
                } else if(selectValue != 0) {
                    if(compatName != "AURA")
                        capacityMultiplier = 1.2;
                    else 
                        capacityMultiplier = 0.8;
                }
            }

            return capacityMultiplier;
        },
        async drop(ev) {
            ev.preventDefault();
            const id = ev.dataTransfer.getData("text");
            const target = ev.target;
            const img = document.querySelector(`#${id}`);
            const baseDrain = parseInt(img.getAttribute("basedrain"));
            let modLevel = parseInt(img.getAttribute("modlevel"));
            const modType = target.getAttribute("modtype");
            const compatName = img.getAttribute("compatname");
            const polarity = parseInt(img.getAttribute("polarity"));
            const modID = img.getAttribute("modid");
            const selectID = target.getAttribute("selectid");
            let modLevelID = target.getAttribute("modlevelid");
            const polaritySelect = document.getElementById(selectID);
            const backMultiplier = parseFloat(img.getAttribute("multiplier"));
            let capacityMultiplier = 1;

            if(!isNaN(backMultiplier)) {
                capacityMultiplier = backMultiplier;
            }

            if(polaritySelect) {
                const selectValue = parseInt(polaritySelect.value);

                if(selectValue == polarity && selectValue != 0) {
                    if(compatName != "AURA")
                        capacityMultiplier = 0.5;
                    else 
                        capacityMultiplier = 2;
                } else if(selectValue != 0) {
                    if(compatName != "AURA")
                        capacityMultiplier = 1.2;
                    else 
                        capacityMultiplier = 0.8;
                }
            }
            
            img.setAttribute("multiplier", capacityMultiplier);
        
            const children = target.querySelectorAll("img");
            const futureCapacity = modType != "card-holder" ? (capacity-(baseDrain+modLevel)) : 0;

        
            if(children.length !== 0 || target.tagName == "IMG"
            || futureCapacity < 0)
                return;
            
            let success = false;
            
            switch(modType) {
                case "aura":
                    if(compatName == 66) {
                        target.appendChild(img);
                        success = true;
                    } else {
                        alert("Ez nem ide való!");
                    }
                    break;
                case "not-aura":
                    if(compatName != 66) {
                        target.appendChild(img);
                        success = true;
                    } else {
                        alert("Ez nem ide való!");
                    }
                    break;
                case "card-holder":
                    target.appendChild(img);
                    success = true;
                    break;
            }
        
            if(success) {
                this.changeEffectValues(modID, modType, baseDrain, capacityMultiplier);
            }
        },
        saveModal() {

        }
    },
    components: {
        'polarityHtml': {
            template:this
        }
    },
    mounted() {
        this.getCharacterData();
        this.getEffectTypes();
        this.getPolarities();
        this.getMods().then(()=> {
            this.capacityTD = document.querySelector("#capacity");
            this.cards = document.querySelectorAll(".card");
            this.cardHolders = document.querySelectorAll(".card-holder");
            this.makeEvents();

            const setID = this.getSetID();
            
            if(!isNaN(setID))
                this.getSetData();
        });
    }
}).mount("#app");

$('#myModal').on('shown.bs.modal', function () {
    $('#myInput').focus()
})
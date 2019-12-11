<template>
    <div>
        <div v-if="nowNumber !== null" class="number"><p>{{ nowNumber }}</p></div>

        <div class="issued">
            <ul>
                <li v-bind:class="{square_color: bingoNumberObject.isIssued}" v-for="(bingoNumberObject, index) in bingoNumberObjectList" :key="index">
                    {{bingoNumberObject.id}}
                </li>
            </ul>
        </div>

        <div class="button">
            <button v-show="!isStarted" @click="startBingo">スタート</button>
            <button v-show="isStarted" @click="getNextBingoNumber">ルーレット！</button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'BingoNumberComponent',
    props: ['roomid'],
    data() {
        return {
            isStarted: false,
            nowNumber: null,
            bingoNumberList: [],
            bingoNumberObjectList: [],
            prefix: this.roomid + '_',
            participants: []
        }
    },
    mounted() {
        this.startBingo();
    },
    methods: {
        startBingo() {
            this.nowNumber = this.localGet('nowNumber');

            this.bingoNumberList = JSON.parse(this.localGet('bingoNumberList'));
            if (!this.bingoNumberList) {
                this.bingoNumberList = this.createBingoNumberList();
            }

            this.bingoNumberObjectList = JSON.parse(this.localGet('bingoNumberObjectList'));
            if (!this.bingoNumberObjectList) {
                this.bingoNumberObjectList = this.createBingoNumberObjectList();
            }

            this.localSave('bingoNumberList', JSON.stringify(this.bingoNumberList));
            this.localSave('bingoNumberObjectList', JSON.stringify(this.bingoNumberObjectList));
            this.isStarted = true;
        },
        endBingo() {
            this.localRemove('nowNumber');
            this.localRemove('bingoNumberList');
            this.localRemove('bingoNumberObjectList');
            this.isStarted = false;
        },
        createBingoNumberList() {
            return Array.from(Array(75), (v, k) => {
                let num = 1 + k;
                if (75 < num) return null;
                k = num;
                return k;
            }).filter(v => v);
        },
        createBingoNumberObjectList() {
            let arrayObject = [];
            for (let i = 1; i < 76; i++) {
                arrayObject.push({id: i, isIssued: false});
            }

            return arrayObject;
        },
        getNextBingoNumber() {
            if (this.bingoNumberList.length === 0) {
                this.endBingo();
                return;
            }
            this.shuffle();
            this.nowNumber = this.bingoNumberList.pop();
            this.bingoNumberObjectList[this.nowNumber - 1].isIssued = true;
            this.localSave('nowNumber', this.nowNumber);
            this.localSave('bingoNumberList', JSON.stringify(this.bingoNumberList));
            this.localSave('bingoNumberObjectList', JSON.stringify(this.bingoNumberObjectList));
        },
        getParticipants() {
            axios.get('/room/' + this.roomid + '/participants').then(response => {
                console.log(response.data);
                this.participants = response.data;
            });
        },
        shuffle() {
            for(let i = this.bingoNumberList.length - 1; i > 0; i--){
                let r = Math.floor(Math.random() * (i + 1));
                let tmp = this.bingoNumberList[i];
                this.bingoNumberList[i] = this.bingoNumberList[r];
                this.bingoNumberList[r] = tmp;
            }
        },
        localSave(key, value) {
            localStorage.setItem(this.prefix + key, value);
        },
        localGet(key) {
            return localStorage.getItem(this.prefix + key);
        },
        localRemove(key) {
            localStorage.removeItem(this.prefix + key);
        }
    }
}
</script>

<style scoped>
.number {
    text-align: center;
}

.number p {
    font-size: 120px;
    border: medium solid #00bfff;
    display: inline-block;
    padding: 50px;
    margin: 0 auto;
}

.button {
    text-align: center;
    margin-top: 10px;
}

.button button {
    display: inline-block;
    padding: 0.3em 1em;
    text-decoration: none;
    color: #67c5ff;
    border: solid 2px #67c5ff;
    border-radius: 3px;
    transition: .4s;
    font-size: 40px;
}

ul {
    display: flex;
    flex-wrap: wrap;
}

ul li {
    color: #67c5ff;
    padding: 0.5em 2em;
    border: solid 2px #67c5ff;
    border-radius: 3px;
    margin:  10px;
    align-self: stretch;
    display: inline-block;
}

.square_color {
    background-color: #67c5ff;
    color: #fff;
}
</style>

<template>
    <div>
        <div class="number">
            <p v-if="!isRandom">{{ nowNumber }}</p>
            <p v-if="isRandom">{{ randomNumber }}</p>
        </div>

        <div class="issued">
            <table border="1">
                <tr>
                    <th v-bind:class="{square_color: bingoNumberObject.isIssued}" v-for="(bingoNumberObject, index) in bingoNumberObjectList" :key="index" v-if="index < 15">
                        {{bingoNumberObject.id}}
                    </th>
                </tr>
                <tr>
                    <th v-bind:class="{square_color: bingoNumberObject.isIssued}" v-for="(bingoNumberObject, index) in bingoNumberObjectList" :key="index" v-if="index > 14 && index < 30">
                        {{bingoNumberObject.id}}
                    </th>
                </tr>
                <tr>
                    <th v-bind:class="{square_color: bingoNumberObject.isIssued}" v-for="(bingoNumberObject, index) in bingoNumberObjectList" :key="index" v-if="index > 29 && index < 45">
                        {{bingoNumberObject.id}}
                    </th>
                </tr>
                <tr>
                    <th v-bind:class="{square_color: bingoNumberObject.isIssued}" v-for="(bingoNumberObject, index) in bingoNumberObjectList" :key="index" v-if="index > 44 && index < 60">
                        {{bingoNumberObject.id}}
                    </th>
                </tr>
                <tr>
                    <th v-bind:class="{square_color: bingoNumberObject.isIssued}" v-for="(bingoNumberObject, index) in bingoNumberObjectList" :key="index" v-if="index > 59 && index < 75">
                        {{bingoNumberObject.id}}
                    </th>
                </tr>
            </table>
        </div>

        <div class="button">
            <button v-show="!isStarted" @click="startBingo">スタート</button>
            <button v-show="isStarted" @click="getNextBingoNumber" v-bind:disabled="isRandom">ルーレット！</button>
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
            nowNumber: 0,
            randomNumber: 0,
            isRandom: false,
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
            if (this.nowNumber === null) {
                this.nowNumber = 0;
            }

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

            this.isRandom = true;
            this.shuffle();
            this.shuffleLoop(75, 0);
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
        shuffleLoop(maxCount, i) {
            if (i <= maxCount) {
                this.randomNumber = Math.floor(Math.random() * this.bingoNumberList.length);
                setTimeout(() => {this.shuffleLoop(maxCount, ++i)}, 10);
            } else {
                this.nowNumber = this.bingoNumberList.pop();
                this.bingoNumberObjectList[this.nowNumber - 1].isIssued = true;
                this.isRandom = false;
                this.localSave('nowNumber', this.nowNumber);
                this.localSave('bingoNumberList', JSON.stringify(this.bingoNumberList));
                this.localSave('bingoNumberObjectList', JSON.stringify(this.bingoNumberObjectList));
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
    color: #420098;
}

.number p {
    font-size: 180px;
    border: medium solid #420098;
    display: inline-block;
    padding: 50px;
    margin: 0 auto;
    font-weight: 900;
    width: 50vw;
    box-sizing: border-box;
}

.button {
    text-align: center;
    margin-top: 10px;
}

.button button {
    display: inline-block;
    padding: 0.3em 1em;
    text-decoration: none;
    color: #420098;
    border: solid 2px #420098;
    border-radius: 3px;
    transition: .4s;
    font-size: 40px;
}

table {
    width: 100vw;
    height: 48vh;
    border-collapse: collapse;
    margin-top: 10px;
}

table th{
    border:solid 1px #420098;
    text-align: center;
    padding: 10px 0;
    font-size: 60px;
    font-weight: bold;
    color: #420098;
}

.square_color {
    background-color: #420098;
    color: #fff;
}
</style>

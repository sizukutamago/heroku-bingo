<template>
    <div>
        <div v-if="nowNumber !== null" class="number"><p>{{ nowNumber }}</p></div>

        <div class="issued">
            <ul>
                <li  v-for="bingoNumber in bingoNumberList">
                    {{bingoNumber}}
                </li>
            </ul>
        </div>

        <div class="button">
            <button v-show="!isStarted" @click="startBingo">スタート</button>
            <button v-show="isStarted" @click="getNextBingoNumber">回す</button>
            <!--<button v-show="isStarted" @click="endBingo">終わる</button>-->
        </div>
    </div>
</template>

<script>
export default {
    name: 'BingoNumberComponent',
    data() {
        return {
            isStarted: false,
            nowNumber: null,
            bingoNumberList: []
        }
    },
    mounted() {
        this.bingoNumberList = JSON.parse(localStorage.getItem('bingoNumberList'));
        this.isStarted = (this.bingoNumberList != null);
    },
    methods: {
        startBingo() {
            this.bingoNumberList = this.range(1, 75);
            localStorage.setItem('bingoNumberList', JSON.stringify(this.bingoNumberList));
            this.isStarted = true;
            this.nowNumber = null;
        },
        endBingo() {
            this.bingoNumberList = null;
            localStorage.removeItem('bingoNumberList');
            this.isStarted = false;
        },
        range(min, max) {
            return Array.from(Array(max), (v, k) => {
                let num = min + k;
                if (max < num) return null;
                k = num;
                return k;
            }).filter(v => v);
        },
        getNextBingoNumber() {
            if (this.bingoNumberList.length === 0) {
                this.isStarted = false;
                return;
            }
            this.shuffle();
            this.nowNumber = this.bingoNumberList.pop();
        },
        shuffle() {
            for(let i = this.bingoNumberList.length - 1; i > 0; i--){
                let r = Math.floor(Math.random() * (i + 1));
                let tmp = this.bingoNumberList[i];
                this.bingoNumberList[i] = this.bingoNumberList[r];
                this.bingoNumberList[r] = tmp;
            }
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
</style>

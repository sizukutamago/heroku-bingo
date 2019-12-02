<template>
    <div>
        <p>{{ nowNumber }}</p>

        <button v-show="!isStarted" @click="startBingo">スタート</button>
        <button v-show="isStarted" @click="getNextBingoNumber">回す</button>
        <button v-show="isStarted" @click="endBingo">終わる</button>
    </div>
</template>

<script>
export default {
    name: 'BingoNumberComponent',
    data() {
        return {
            isStarted: false,
            nowNumber: 0,
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

</style>

<template>
    <div>
        <header>
            <img class="bingo-header" src="/img/bingo.jpg"/>
            <p>{{username}}</p>
        </header>
        <table>
            <tr v-for="(columns, index) in bingoCard" :key="index">
                <td v-bind:class="{'bingo-pushed': column.isClicked}" @click="pushColumn(column)" v-for="column in columns" :key="column.id">
                    <img style="width: 100%;padding: 0;" v-if="column.id === 'bingo!'" src="/img/heroku-logo.png"/>
                    <span v-else>{{ column.id }}</span>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
export default {
    name: 'BingoCardComponent',
    props: [
        'roomid',
        'username'
    ],
    data() {
        return {
            bingoCard: [
                [],
                [],
                [],
                [],
                []
            ],
            prefix: this.roomid + '_'
        }
    },
    mounted() {
        const bingoCard = JSON.parse(this.localGet('bingoCard'));
        if (bingoCard !== null) {
            this.bingoCard = bingoCard;
        } else {
            this.createBingoCard();
        }
    },
    methods: {
        createBingoCard() {
            let lines = [];
            lines[0] = this.range(1, 15);
            lines[1] = this.range(16, 30);
            lines[2] = this.range(31, 45);
            lines[3] = this.range(46, 60);
            lines[4] = this.range(61, 75);

            for (let i = 0; i < 5; i++) {
                for (let y = 0; y < 5; y++) {
                    if (i === 2 && y === 2) {
                        this.bingoCard[i].push({id: 'bingo!', isClicked: true});
                    } else {
                        this.bingoCard[i].push({id: lines[y].pop(), isClicked: false});
                    }
                }
            }
            this.localSave('bingoCard', JSON.stringify(this.bingoCard));
        },
        range(min, max) {
            return this.shuffle(Array.from(Array(max), (v, k) => {
                let num = min + k;
                if (max < num) return null;
                k = num;
                return k;
            }).filter(v => v));
        },
        shuffle(array) {
            for(let i = array.length - 1; i > 0; i--){
                let r = Math.floor(Math.random() * (i + 1));
                let tmp = array[i];
                array[i] = array[r];
                array[r] = tmp;
            }
            return array;
        },
        pushColumn(bingoColumn) {
            if (bingoColumn.id === 'bingo!') {
                return;
            }

            bingoColumn.isClicked = !bingoColumn.isClicked;
            this.localSave('bingoCard', JSON.stringify(this.bingoCard));
            //todo: reachの状態が変わった時だけ投げるようにする
            axios.get('/room/' + this.roomid + '/reach?isReach=' + this.checkReach() + '&username=' +this.username).then(response => {
                console.log(response);
            });
        },
        checkReach() {
            // 横チェック
            for (let i = 0; i < this.bingoCard.length; i++) {
                let count = 0;
                for (let y = 0; y < this.bingoCard[i].length; y++) {
                    if (this.bingoCard[i][y].isClicked) count++;
                }
                if (count === 4) {
                    return true;
                }
            }

            //縦チェック
            for (let i = 0; i < this.bingoCard.length; i++) {
                let count = 0;
                for (let y = 0; y < this.bingoCard[i].length; y++) {
                    if (this.bingoCard[y][i].isClicked) count++;
                }
                if (count === 4) {
                    return true;
                }
            }

            // 左上から右下にかけて
            let count = 0;
            for (let i = 0; i < this.bingoCard.length; i++) {
                if (this.bingoCard[i][i].isClicked) count++;
            }

            if (count === 4) return true;

            // 右上から左下にかけて
            count = 0;
            for (let i = 0; i < this.bingoCard.length; i++) {
                if (this.bingoCard[i][(4 - i)].isClicked) count++;
            }

            return count === 4;
        },
        localSave(key, value) {
            localStorage.setItem(this.prefix + key, value);
        },
        localGet(key) {
            return localStorage.getItem(this.prefix + key);
        }
    }
}
</script>

<style scoped>
header p {
    float: right;
    margin-right: 10px;
}

.bingo-header {
    height: 15vh;
    width: 100%;
}
table{
    width: 100%;
    height: 70vh;
    border-collapse: collapse;
}

table th,table td{
    border:solid 2px #49c5f0;
    text-align: center;
    height: 10vh;
    width: 20vw;
}

.bingo-pushed {
    background: #49c5f0;
}
</style>

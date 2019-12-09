<template>
    <div>
        <p>{{username}}</p>
        <header>
            <img class="bingo-header" src="/img/bingo.jpg"/>
        </header>
        <table>
            <tr v-for="(columns, index) in bingoCard" :key="index">
                <td v-bind:class="{'bingo-pushed': column.isClicked}" @click="pushColumn(column)" v-for="column in columns" :key="column.id">
                    {{ column.id }}
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
            bingoColumn.isClicked = !bingoColumn.isClicked;
            this.localSave('bingoCard', JSON.stringify(this.bingoCard));
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
.bingo-header {
    height: 15vh;
    width: 100%;
    margin-bottom: 5vh;
}
table{
    width: 100%;
    height: 70vh;
    border-collapse: collapse;
}

table th,table td{
    border:solid 2px #49c5f0;
    text-align: center;
    height: 10px;
    width: 20vw;
}

.bingo-pushed {
    background: #49c5f0;
}
</style>

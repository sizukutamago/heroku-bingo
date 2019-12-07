<template>
    <div>
        <header>
            <img class="bingo-header" src="/img/bingo.jpg"/>
        </header>
        <table>
            <tr>
                <td>{{firstLine[0]}}</td>
                <td>{{secondLine[0]}}</td>
                <td>{{thirdLine[0]}}</td>
                <td>{{fourthLine[0]}}</td>
                <td>{{fifthLine[0]}}</td>
            </tr>
            <tr>
                <td>{{firstLine[1]}}</td>
                <td>{{secondLine[1]}}</td>
                <td>{{thirdLine[1]}}</td>
                <td>{{fourthLine[1]}}</td>
                <td>{{fifthLine[1]}}</td>
            </tr>
            <tr>
                <td>{{firstLine[2]}}</td>
                <td>{{secondLine[2]}}</td>
                <td bgcolor="#49c5f0" width="75px" style="color: white; font-size: 17px">bingo!</td>
                <td>{{fourthLine[2]}}</td>
                <td>{{fifthLine[2]}}</td>
            </tr>
            <tr>
                <td>{{firstLine[3]}}</td>
                <td>{{secondLine[3]}}</td>
                <td>{{thirdLine[3]}}</td>
                <td>{{fourthLine[3]}}</td>
                <td>{{fifthLine[3]}}</td>
            </tr>
            <tr>
                <td>{{firstLine[4]}}</td>
                <td>{{secondLine[4]}}</td>
                <td>{{thirdLine[4]}}</td>
                <td>{{fourthLine[4]}}</td>
                <td>{{fifthLine[4]}}</td>
            </tr>
        </table>
    </div>
</template>

<script>
export default {
    name: 'BingoCardComponent',
    data() {
        return {
            firstLine: [],
            secondLine: [],
            thirdLine: [],
            fourthLine: [],
            fifthLine: []
        }
    },
    mounted() {
        this.firstLine = this.getBingoColumn(this.range(1, 15));
        this.secondLine = this.getBingoColumn(this.range(16, 30));
        this.thirdLine = this.getBingoColumn(this.range(31, 45));
        this.fourthLine = this.getBingoColumn(this.range(46, 60));
        this.fifthLine = this.getBingoColumn(this.range(61, 75));

        const tds = document.getElementsByTagName('td');
        for (let i = 0; i < tds.length; i++) {
            tds[i].addEventListener('click', event => {
                event.target.style.background = '#49c5f0';
                event.target.style.color = 'white';
            });
        }
    },
    methods: {
        range(min, max) {
            return Array.from(Array(max), (v, k) => {
                let num = min + k;
                if (max < num) return null;
                k = num;
                return k;
            }).filter(v => v);
        },
        getBingoColumn(array) {
            for(let i = array.length - 1; i > 0; i--){
                let r = Math.floor(Math.random() * (i + 1));
                let tmp = array[i];
                array[i] = array[r];
                array[r] = tmp;
            }
            return array.slice(0, 5);
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
    font-size: 40px;
}
</style>

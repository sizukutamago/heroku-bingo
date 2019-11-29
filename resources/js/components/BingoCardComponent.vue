<template>
    <div>
        <table border="1">
            <tr>
                <td>1</td>
                <td>16</td>
                <td>31</td>
                <td>46</td>
                <td>61</td>
            </tr>
            <tr>
                <td>2</td>
                <td>17</td>
                <td>32</td>
                <td>47</td>
                <td>62</td>
            </tr>
            <tr>
                <td>3</td>
                <td>18</td>
                <td>0</td>
                <td>48</td>
                <td>63</td>
            </tr>
            <tr>
                <td>4</td>
                <td>19</td>
                <td>34</td>
                <td>49</td>
                <td>64</td>
            </tr>
            <tr>
                <td>5</td>
                <td>20</td>
                <td>35</td>
                <td>50</td>
                <td>65</td>
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
</style>

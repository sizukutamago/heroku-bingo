<template>
    <div>
        <ul>
            <li v-for="(participant, index) in participants" :key="index">
                {{participant.username}}
                <p v-if="participant.is_reach">
                    リーチ！
                </p>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'BingoParticipant',
    props: ['roomid'],
    data() {
        return {
            participants: []
        }
    },
    mounted() {
        setInterval(this.getParticipants, 5000);
    },
    methods: {
        getParticipants() {
            axios.get('/room/' + this.roomid + '/participants').then(response => {
                console.log(response);
                this.participants = response.data;
            });
        },
    }
}
</script>

<style scoped>
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

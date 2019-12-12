<template>
    <div>
        <h2>参加者 {{ participants.length }}人</h2>
        <ul>
            <li v-for="(participant, index) in participants" :key="index">
                {{participant.username}}
                <p class="inline" v-if="participant.is_reach">
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
    padding: 0;
}

ul li {
    color: #67c5ff;
    list-style: none;
    padding: 0;
    display: block;
}

.inline {
    display: inline;
}
</style>

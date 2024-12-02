<template>
    <div>
        <div v-if="score !== null" class="alert ">
            <h3>Total Score: {{ score }}</h3>
        </div>
        <div v-if="score !== null && score > 0">
            <h3 class="mb-4 r">Score History</h3>
            <ul class="list-group mb-4">
                <li v-for="history in scoreHistory" :key="history.id" class="list-group-item">
                    <div>
                        <strong>Event: {{ history.event }}</strong>
                        <p class="mb-1">Score: {{ history.increment }}</p>
                        <p class="mb-1">Description: {{ history.description }}</p>
                        <p class="mb-1">Date: {{ new Date(history.created_at).toLocaleString() }}</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            score: null,
            scoreHistory: []
        };
    },
    mounted() {
        this.fetchScore();
        this.fetchScoreHistory();
    },
    methods: {
        fetchScore() {
            axios.get('/v1/leaderboard/my-score').then(response => {
                this.score = response.data.score;
            });
        },
        fetchScoreHistory() {
            axios.get('/v1/leaderboard/my-score-history').then(response => {
                this.scoreHistory = response.data;
            });
        }
    }
};
</script>
<template>
    <div>
        <div v-if="score !== null" class="alert bg-primary">
            <h3>Total Score: {{ score }}</h3>
        </div>
        <div>
            <h3 class="mb-4">Score History</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Score</th>
                        <th>Description</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="history in scoreHistory" :key="history.id">
                        <td>{{ history.id }}</td>
                        <td>{{ history.increment }}</td>
                        <td>{{ history.description }}</td>
                        <td>{{ formatDate(history.created_at) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
 
<script>
import apiService from '@/apiGuestService.js';
import { format } from 'date-fns';

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
        async fetchScore() {
            try {
                const response = await apiService.getScore();
                this.score = response.data.score;
            } catch (error) {
                console.error('Error fetching score:', error);
            }
        },
        async fetchScoreHistory() {
            try {
                const response = await apiService.getScoreHistory();
                this.scoreHistory = response.data;
            } catch (error) {
                console.error('Error fetching score history:', error);
            }
        },
        formatDate(date) {
            return format(new Date(date), 'yyyy-MM-dd HH:mm:ss');
        }
    }
};
</script>
 
<template>
    <div class="mt-4">
        <h4>Increase Score</h4>
        <form @submit.prevent="increaseScore" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="increment" class="form-label">Increment Score:</label>
                <input type="number" v-model="increment" id="increment" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="event" class="form-label">Event:</label>
                <input type="text" v-model="event" id="event" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea v-model="description" id="description" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Increase</button>
        </form>
        <div v-if="scoreHistory.length" class="mt-4">
            <h4>Score History</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Increment</th>
                        <th>Event</th>
                        <th>Description</th>
                        <th>Updated By</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="score in scoreHistory" :key="score.id">
                        <td>{{ score.increment }}</td>
                        <td>{{ score.event }}</td>
                        <td>{{ score.description }}</td>
                        <td>{{ score.updated_by }}</td>
                        <td>{{ formatTimeAgo(score.created_at) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else>
            <p>No data available</p>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { formatDistanceToNow } from 'date-fns';
import apiService from '@/apiService';

export default {
    props: {
        studentId: {
            type: String,
            required: true,
        },
    },
    setup(props) {
        const increment = ref(0);
        const event = ref('');
        const description = ref('');
        const scoreHistory = ref([]);

        const fetchScoreHistory = () => {
            apiService.getScoreHistory(props.studentId)
                .then(response => {
                    scoreHistory.value = response.data;
                })
                .catch(error => {
                    console.error('Error fetching score history:', error);
                });
        };

        const increaseScore = () => {
            const payload = {
                increment: increment.value,
                event: event.value,
                description: description.value,
            };
            apiService.increaseScore(props.studentId, payload)
                .then(response => {
                    console.log(response.data);
                    fetchScoreHistory(); // Refresh the score history
                })
                .catch(error => {
                    console.error('Error increasing score:', error);
                });
        };

        const formatTimeAgo = (date) => {
            return formatDistanceToNow(new Date(date), { addSuffix: true });
        };

        onMounted(fetchScoreHistory);

        return {
            increment,
            event,
            description,
            scoreHistory,
            increaseScore,
            formatTimeAgo,
        };
    },
};
</script>
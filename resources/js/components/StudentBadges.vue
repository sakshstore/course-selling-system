<template>
    <div v-if="badges.length" class="mt-3">
        <h4>Badges</h4>
        <ul class="list-group">
            <li v-for="badge in badges" :key="badge.id" class="list-group-item">
                {{ badge.name }} - {{ badge.description }}
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            badges: [],
        };
    },
    props: {
        studentId: {
            type: String,
            required: true,
        },
    },
    created() {
        this.fetchBadges();
    },
    methods: {
        fetchBadges() {
            axios.get(`/v1/students/${this.studentId}/badges`)
                .then(response => {
                    this.badges = response.data;
                })
                .catch(error => {
                    console.error('Error fetching badges:', error);
                });
        },
    },
};
</script>
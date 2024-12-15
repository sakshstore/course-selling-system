<template>
<div>

    <div v-if="score !== null" class="alert bg-primary">
        <h3>Total Score: {{ score }}</h3>
    </div>

    <!-- Welcome Message -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Welcome, {{ user.name }}!</h5>
            <p class="card-text">Last login: {{ user.last_login_at }}</p>
        </div>
    </div>

    <!-- My Courses -->
    <div v-if="myCourses.length" class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">My Courses</h5>
            <p class="card-text">Courses you are currently enrolled in:</p>
            <div class="row">
                <div class="col-md-2" v-for="course in myCourses.slice(0, 5)" :key="course.id">
                    <div class="card">
                        <img :src="getThumbnail(course.thumbnail)" class="card-img-top" alt="Course Thumbnail">
                        <div class="card-body">
                            <h5 class="card-title">{{ course.title }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recommended Courses -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Recommended Courses</h5>
            <p class="card-text">Based on your interests:</p>
            <div class="row">
                <div class="col-md-2" v-for="course in recommendedCourses.slice(0, 5)" :key="course.id">
                    <div class="card">
                        <img :src="getThumbnail(course.thumbnail)" class="card-img-top" alt="Course Thumbnail">
                        <div class="card-body">
                            <h5 class="card-title">{{ course.title }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Widget -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">User Notifications</h5>
            <ul class="list-group">
                <li class="list-group-item" v-for="notification in notifications.slice(0, 5)" :key="notification.id">
                    {{ notification.data.message }} - {{ formatTimeAgo(notification.created_at) }}
                </li>
            </ul>
        </div>
    </div>

    <!-- Score Widget -->

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Score History</h5>

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
                    <tr v-for="history in scoreHistory.slice(0, 5)" :key="history.id">
                        <td>{{ history.id }}</td>
                        <td>{{ history.increment }}</td>
                        <td>{{ history.description }}</td>
                        <td>{{ formatDate(history.created_at) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Other sections... -->
</div>
</template>

<script>
import {
    ref,
    onMounted
} from 'vue';
import apiService from '@/apiGuestService.js';
import {
    formatDistanceToNow,
    format
} from 'date-fns';

export default {
    name: 'Dashboard',
    setup() {
        const user = ref({});
        const myCourses = ref([]);
        const recommendedCourses = ref([]);
        const logins = ref([]);
        const notifications = ref([]);
        const score = ref(null);
        const scoreHistory = ref([]);

        const fetchUserData = async () => {
            try {
                const response = await apiService.getUserData();
                user.value = response.data;
            } catch (error) {
                console.error('Error fetching user data:', error);
            }
        };

        const fetchMyCourses = async () => {
            try {
                const response = await apiService.getMyCourses();
                myCourses.value = response.data;
            } catch (error) {
                console.error('Error fetching my courses:', error);
            }
        };

        const fetchRecommendedCourses = async () => {
            try {
                const response = await apiService.getRecommendedCourses();
                recommendedCourses.value = response.data;
            } catch (error) {
                console.error('Error fetching recommended courses:', error);
            }
        };

        const fetchNotifications = async () => {
            try {
                const response = await apiService.getNotifications();
                notifications.value = response.data;
            } catch (error) {
                console.error('Error fetching notifications:', error);
            }
        };

        const fetchScore = async () => {
            try {
                const response = await apiService.getScore();
                score.value = response.data.score;
            } catch (error) {
                console.error('Error fetching score:', error);
            }
        };

        const fetchScoreHistory = async () => {
            try {
                const response = await apiService.getScoreHistory();
                scoreHistory.value = response.data;
            } catch (error) {
                console.error('Error fetching score history:', error);
            }
        };

        const getThumbnail = (thumbnail) => {
            return thumbnail || 'https://picsum.photos/id/1/367/267';
        };

        const formatTimeAgo = (date) => {
            return formatDistanceToNow(new Date(date), {
                addSuffix: true
            });
        };

        const formatDate = (date) => {
            return format(new Date(date), 'yyyy-MM-dd HH:mm:ss');
        };

        onMounted(() => {
            fetchUserData();
            fetchMyCourses();
            fetchRecommendedCourses();

            fetchNotifications();
            fetchScore();
            fetchScoreHistory();
        });

        return {
            user,
            myCourses,
            recommendedCourses,

            notifications,
            score,
            scoreHistory,
            getThumbnail,
            formatTimeAgo,
            formatDate
        };
    }
};
</script>

<style scoped>
.card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
}
</style>

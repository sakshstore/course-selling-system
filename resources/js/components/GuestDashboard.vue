<template>
    <div >
     
              <!-- Welcome Message -->
              <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Welcome, {{ user.name }}!</h5>
                        <p class="card-text"> Last login {{ user.last_login_at	 }}</p>
                    </div>
                </div>
 

        <!-- My Courses -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">My Courses</h5>
                <p class="card-text">Courses you are currently enrolled in:</p>
                <div class="row">
                    <div class="col-md-2" v-for="course in myCourses" :key="course.id">
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
                    <div class="col-md-2" v-for="course in recommendedCourses" :key="course.id">
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

        <!-- Recently Viewed Courses -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Recently Viewed Courses</h5>
                <p class="card-text">Pick up where you left off:</p>
                <div class="row">
                    <div class="col-md-2" v-for="course in recentlyViewedCourses" :key="course.id">
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

        <!-- Other sections... -->
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Dashboard',
    data() {
        return {
            user: {},
            myCourses: [],
            recommendedCourses: [],
            recentlyViewedCourses: []
        };
    },
    created() {
        this.fetchUserData();
        this.fetchMyCourses();
        this.fetchRecommendedCourses();
        this.fetchRecentlyViewedCourses();
    },
    methods: {
        fetchUserData() {
            axios.get('/v1/me')
                .then(response => {
                    this.user = response.data;
                })
                .catch(error => {
                    console.error('Error fetching user data:', error);
                });
        },
        fetchMyCourses() {
            axios.get('/v1/my-courses')
                .then(response => {
                    this.myCourses = response.data;
                })
                .catch(error => {
                    console.error('Error fetching my courses:', error);
                });
        },
        fetchRecommendedCourses() {
            axios.get('/v1/recommended-courses')
                .then(response => {
                    this.recommendedCourses = response.data;
                })
                .catch(error => {
                    console.error('Error fetching recommended courses:', error);
                });
        },
        fetchRecentlyViewedCourses() {
            axios.get('/v1/recently-viewed-courses')
                .then(response => {
                    this.recentlyViewedCourses = response.data;
                })
                .catch(error => {
                    console.error('Error fetching recently viewed courses:', error);
                });
        },
        getThumbnail(thumbnail) {
            return thumbnail || 'https://picsum.photos/id/1/367/267';
        }
    }
};
</script>

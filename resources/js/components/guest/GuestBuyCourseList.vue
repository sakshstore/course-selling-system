<template>
    <div>
        <h2 class="mb-4">All Courses</h2>
        <div class="row">
            <div v-for="course in courses" :key="course.id" class="col-md-2 mb-4">
               
               
               
                <div @click="viewCourseDetails(course.id)" class="course-item border">
                    <img :src="getThumbnail(course.thumbnail)" class="card-img-top" alt="Course Thumbnail">
                    <div class="course-info p-3">
                        <h5  class="course-title">{{ course.title }}</h5>
                        <p class="course-description">{{ course.description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import apiService from '@/apiGuestService.js';

export default {
    data() {
        return {
            courses: []
        };
    },
    created() {
        this.fetchCourses();
    },
    methods: {
        fetchCourses() {
            apiService.getCourses().then(response => {
                this.courses = response.data;
            });
        },
        viewCourseDetails(courseId) {
            this.$router.push({ name: 'GuestBuyCourseDetails', params: { id: courseId } });
        },
        getThumbnail(thumbnail) {
            return thumbnail || 'https://picsum.photos/id/1/367/267';
        }
    }
};
</script>



<style scoped>
.course-item {
    cursor: pointer;
    transition: transform 0.3s, box-shadow 0.3s;
}

.course-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
}

.course-title {
    font-size: 1.2rem;
    font-weight: bold;
}

.course-description {
    font-size: 0.9rem;
    color: #666;
}
</style>
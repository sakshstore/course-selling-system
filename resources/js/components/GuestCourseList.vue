<template>
    <div>
        <h2 class="mb-4">Courses</h2>
        <div class="row">
            <div v-for="course in courses" :key="course.id" class="col-md-2 mb-4">
                <div class="course-item border" >
                 
                    <img :src="getThumbnail(course.thumbnail)" class="card-img-top" alt="Course Thumbnail">


                    <div class="course-info  p-3">
                        <h5 @click="viewCourseDetails(course.id)"  class="course-title">{{ course.title }}</h5>
                        <p class="course-description">{{ course.description }}</p>
 

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

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
            axios.get('/v1/courses').then(response => {
                this.courses = response.data;
            });
        },
        viewCourseDetails(courseId) {
            this.$router.push({ name: 'GuestCourseDetails', params: { id: courseId } });
        },

        getThumbnail(thumbnail) {
            return thumbnail || 'https://picsum.photos/id/1/367/267';
        }
    }
};
</script> 
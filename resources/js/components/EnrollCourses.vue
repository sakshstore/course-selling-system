<template>
    <div>ddddddddddddddddddd
        <div class="row" v-if="purchasedcourseList.length">
            <p>Purchased Course List</p>
            <div class="col-md-2" v-for="course in purchasedcourseList" :key="course.id">
                <div class="card">
                    <img :src="getThumbnail(course.thumbnail)" class="card-img-top" alt="Course Thumbnail">
                    <div class="card-body">
                        <h5 class="card-title">{{ course.title }}</h5>
                        <button @click="removelInCourse(course.id)" class="btn btn-primary btn-sm">Remove</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" v-if="courseList.length">
            <p>All Course List</p>
            <div class="col-md-2" v-for="course in courseList" :key="course.id">
                <div class="card">
                    <img :src="getThumbnail(course.thumbnail)" class="card-img-top" alt="Course Thumbnail">
                    <div class="card-body">
                        <h5 class="card-title">{{ course.title }}</h5>
                        <button @click="enrollInCourse(course.id)"
                            class="btn btn-primary btn-sm float-end">Enroll</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        studentId: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            purchasedcourseList: [],
            courseList: [],
        };
    },
    methods: {
        fetchCourseList() {


            axios.get('/v1/courses').then(response => {
                this.courseList = response.data;
            });
            axios.get(`/v1/students/${this.studentId}/courses`)
                .then(response => {
                    this.purchasedcourseList = response.data;
                })
                .catch(error => {
                    console.error('Error fetching course list:', error);
                });
        },
        enrollInCourse(courseId) {
            axios.post(`/v1/students/${this.studentId}/course/enroll`, { course_id: courseId })
                .then(response => {
                    alert('Enrolled successfully!');
                    this.fetchCourseList(); // Refresh the course list
                })
                .catch(error => {
                    console.error('Error enrolling in course:', error);
                });
        },
        removelInCourse(courseId) {
            axios.delete(`/v1/students/${this.studentId}/course/remove/`, { data: { course_id: courseId } })
                .then(response => {
                    alert('Removed successfully!');
                    this.fetchCourseList(); // Refresh the course list
                })
                .catch(error => {
                    console.error('Error removing from course:', error);
                });
        },
        getThumbnail(thumbnail) {
            return thumbnail || 'https://picsum.photos/id/1/367/267';
        },
    },
    created() {
        this.fetchCourseList();
    },
};
</script>
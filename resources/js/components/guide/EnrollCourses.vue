<template>
    <div>
        <div class="row" v-if="purchasedcourseList.length">
            <p>Purchased Course List</p>
            <div class="col-md-2" v-for="course in purchasedcourseList" :key="course.id">
                <div class="card">
                    <img :src="getThumbnail(course.thumbnail)" class="card-img-top" alt="Course Thumbnail">
                    <div class="card-body">
                        <h5 class="card-title">{{ course.title }}</h5>
                        <button @click="removeCourse(course.id)" class="btn btn-primary btn-sm">Remove</button>
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
import apiService from '@/apiService.js';

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
        async fetchCourseList() {
            try {
                const coursesResponse = await apiService.getCourses();
                this.courseList = coursesResponse.data;

                const studentCoursesResponse = await apiService.getStudentCourses(this.studentId);
                this.purchasedcourseList = studentCoursesResponse.data;
            } catch (error) {
                console.error('Error fetching course list:', error);
            }
        },
        async enrollInCourse(courseId) {
            try {
                await apiService.enrollInCourse(this.studentId, courseId);
                this.$printtoast('Enrolled successfully!');
                this.fetchCourseList(); // Refresh the course list
            } catch (error) {
                console.error('Error enrolling in course:', error);
            }
        },
        async removeCourse(courseId) {
            try {
                await apiService.removeCourse(this.studentId, courseId);
                this.$printtoast('Removed successfully!');
                this.fetchCourseList(); // Refresh the course list
            } catch (error) {
                console.error('Error removing from course:', error);
            }
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
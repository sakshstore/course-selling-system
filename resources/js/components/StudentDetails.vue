<template>
    <div>
        
        <div v-if="student" class="card p-3 mb-4">
            
            <h2 class="mb-4"> {{ student.name }}</h2>
            <p><strong>Email:</strong> {{ student.email }}</p>
            <p><strong>Registered At:</strong> {{ formatTimeAgo(student.created_at) }}</p>
        </div>

        <ul class="nav nav-tabs" id="myTab" role="tablist">


            <li class="nav-item" role="presentation">
                <button class="nav-link" id="course-list-tab" data-bs-toggle="tab" data-bs-target="#course-list"
                    type="button" role="tab" aria-controls="course-list" aria-selected="false">Course List</button>
            </li>


            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="login-history-tab" data-bs-toggle="tab"
                    data-bs-target="#login-history" type="button" role="tab" aria-controls="login-history"
                    aria-selected="true">Login History</button>
            </li>


            <li class="nav-item" role="presentation">
                <button class="nav-link" id="activity-report-tab" data-bs-toggle="tab" data-bs-target="#activity-report"
                    type="button" role="tab" aria-controls="activity-report" aria-selected="false">Activity
                    Report</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="purchase-history-tab" data-bs-toggle="tab"
                    data-bs-target="#purchase-history" type="button" role="tab" aria-controls="purchase-history"
                    aria-selected="false">Purchase History</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="badges-tab" data-bs-toggle="tab" data-bs-target="#badges" type="button"
                    role="tab" aria-controls="badges" aria-selected="false">Badges</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="increase-score-tab" data-bs-toggle="tab" data-bs-target="#increase-score"
                    type="button" role="tab" aria-controls="increase-score" aria-selected="false">Increase
                    Score</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">


            <div class="tab-pane fade" id="course-list" role="tabpanel" aria-labelledby="course-list-tab">


                <div v-if="purchasedcourseList.length" class="mt-3">
                    <h4>Purchased Course List</h4>



                    <ul class="list-group">



                        <li v-for="course in purchasedcourseList" :key="course.id" class="list-group-item">
                            {{ course.title }} - {{ course.description }}




                            <button @click="removelInCourse(course.id)"
                                class="btn btn-primary btn-sm float-end">Remove</button>



                        </li>
                    </ul>
                </div>



                <div v-if="courseList.length" class="mt-3">
                    <h4>Course List</h4>



                    <ul class="list-group">



                        <li v-for="course in courseList" :key="course.id" class="list-group-item">
                            {{ course.title }} - {{ course.description }}



                            <button @click="enrollInCourse(course.id)"
                                class="btn btn-primary btn-sm float-end">Enroll</button>




                        </li>
                    </ul>
                </div>
            </div>



            <div class="tab-pane fade show active" id="login-history" role="tabpanel"
                aria-labelledby="login-history-tab">
                <div v-if="loginHistory.length" class="mt-3">
                    <h4>Login History</h4>
                    <ul class="list-group">
                        <li v-for="login in loginHistory" :key="login.id" class="list-group-item">
                            {{ formatTimeAgo(login.created_at) }} from {{ login.ip_address }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-pane fade" id="activity-report" role="tabpanel" aria-labelledby="activity-report-tab">
                <div v-if="activityReport.length" class="mt-3">
                    <h4>Activity Report</h4>
                    <ul class="list-group">
                        <li v-for="activity in activityReport" :key="activity.id" class="list-group-item">
                            {{ activity.message }} - {{ formatTimeAgo(activity.created_at) }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-pane fade" id="purchase-history" role="tabpanel" aria-labelledby="purchase-history-tab">
                <div v-if="purchaseHistory.length" class="mt-3">
                    <h4>Purchase History</h4>
                    <ul class="list-group">
                        <li v-for="purchase in purchaseHistory" :key="purchase.id" class="list-group-item">
                            {{ purchase.item_name }} - {{ purchase.amount }} - {{ formatTimeAgo(purchase.created_at) }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-pane fade" id="badges" role="tabpanel" aria-labelledby="badges-tab">
                <div v-if="badges.length" class="mt-3">
                    <h4>Badges</h4>
                    <ul class="list-group">
                        <li v-for="badge in badges" :key="badge.id" class="list-group-item">
                            {{ badge.name }} - {{ badge.description }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-pane fade" id="increase-score" role="tabpanel" aria-labelledby="increase-score-tab">
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
                </div>
            </div>
        </div>
    </div>
</template>
<script>import axios from 'axios';
import { formatDistanceToNow } from 'date-fns';

export default {
    data() {
        return {
            student: null,
            loginHistory: [],
            activityReport: [],
            purchaseHistory: [],
            badges: [],
            increment: 0,
            courseList: [],

            purchasedcourseList: [],


            scoreHistory: []


        };
    },
    created() {
        this.fetchStudentDetails();
        this.fetchLoginHistory();
        this.fetchActivityReport();
        this.fetchPurchaseHistory();
        this.fetchBadges();

        this.fetchScoreHistory();
        this.fetchCourseList();

    },
    methods: {

        fetchCourseList() {
            const studentId = this.$route.params.id;


            axios.get('/v1/courses').then(response => {
                this.courseList = response.data;
            });





            axios.get(`/v1/students/${studentId}/courses`)
                .then(response => {
                    this.purchasedcourseList = response.data;
                })
                .catch(error => {
                    console.error('Error fetching course list:', error);
                });


        },


        fetchStudentDetails() {
            const studentId = this.$route.params.id;
            axios.get(`/v1/students/${studentId}`)
                .then(response => {
                    this.student = response.data;
                })
                .catch(error => {
                    console.error('Error fetching student details:', error);
                });
        },
        fetchLoginHistory() {
            const studentId = this.$route.params.id;
            axios.get(`/v1/students/${studentId}/login-history`)
                .then(response => {
                    this.loginHistory = response.data;
                })
                .catch(error => {
                    console.error('Error fetching login history:', error);
                });
        },
        fetchActivityReport() {
            const studentId = this.$route.params.id;
            axios.get(`/v1/students/${studentId}/activity-report`)
                .then(response => {
                    this.activityReport = response.data;
                })
                .catch(error => {
                    console.error('Error fetching activity report:', error);
                });
        },
        fetchPurchaseHistory() {
            const studentId = this.$route.params.id;
            axios.get(`/v1/students/${studentId}/purchase-history`)
                .then(response => {
                    this.purchaseHistory = response.data;
                })
                .catch(error => {
                    console.error('Error fetching purchase history:', error);
                });
        },
        fetchBadges() {
            const studentId = this.$route.params.id;
            axios.get(`/v1/students/${studentId}/badges`)
                .then(response => {
                    this.badges = response.data;
                })
                .catch(error => {
                    console.error('Error fetching badges:', error);
                });
        },


        increaseScore() {
            const studentId = this.$route.params.id;
            const payload = {
                increment: this.increment,
                event: this.event,
                description: this.description,
              
            };
            axios.post(`/v1/students/${studentId}/increase-score`, payload)
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error(error);
                });
        },

        fetchScoreHistory() { // Add this method
            const studentId = this.$route.params.id;
            axios.get(`/v1/students/${studentId}/score-history`)
                .then(response => {
                    this.scoreHistory = response.data;
                })
                .catch(error => {
                    console.error('Error fetching score history:', error);
                });
        },


        enrollInCourse(courseId) {
            const studentId = this.$route.params.id;
            axios.post(`/v1/students/${studentId}/course/enroll`, { course_id: courseId })
                .then(response => {
                    alert('Enrolled successfully!');
                    this.fetchCourseList(); // Refresh the course list
                })
                .catch(error => {
                    console.error('Error enrolling in course:', error);
                });
        },


        removelInCourse(courseId) {
            const studentId = this.$route.params.id;
            axios.delete(`/v1/students/${studentId}/course/remove/`, { data: { course_id: courseId } })
                .then(response => {
                    alert('Remove successfully!');
                    this.fetchCourseList(); // Refresh the course list
                })
                .catch(error => {
                    console.error('Error removing from course:', error);
                });
        },



        formatTimeAgo(date) {
            return formatDistanceToNow(new Date(date), { addSuffix: true });
        }
    }
};

</script>
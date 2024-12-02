<template>
    <div>
        <div v-if="student" class="card p-3 mb-4">
            <h2 class="mb-4">{{ student.name }}</h2>
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
                <EnrollCourses :studentId="studentId" />
            </div>





            <div class="tab-pane fade" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">
                <!-- Invoice Content -->
                <StudentInvoice :studentId="studentId" />
            </div>



            <div class="tab-pane fade show active" id="login-history" role="tabpanel"
                aria-labelledby="login-history-tab">
                <!-- Login History Content -->
                <StudentLoginHistory :studentId="studentId" />
            </div>
            <div class="tab-pane fade" id="activity-report" role="tabpanel" aria-labelledby="activity-report-tab">
                <!-- Activity Report Content -->
                <StudentActivityReport :studentId="studentId" />
            </div>
            <div class="tab-pane fade" id="purchase-history" role="tabpanel" aria-labelledby="purchase-history-tab">
                <!-- Purchase History Content -->
                <StudentPurchaseHistory :studentId="studentId" />
            </div>
            <div class="tab-pane fade" id="badges" role="tabpanel" aria-labelledby="badges-tab">
                <!-- Badges Content -->
                <StudentBadges :studentId="studentId" />
            </div>
        

        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { formatDistanceToNow } from 'date-fns';
import EnrollCourses from '@/components/EnrollCourses.vue';
import StudentLoginHistory from '@/components/StudentLoginHistory.vue';
import StudentActivityReport from '@/components/StudentActivityReport.vue';
import StudentPurchaseHistory from '@/components/StudentPurchaseHistory.vue';
import StudentBadges from '@/components/StudentBadges.vue';
import StudentIncreaseScore from '@/components/StudentIncreaseScore.vue';
 
export default {
    components: {
        EnrollCourses,
        StudentLoginHistory,
        StudentActivityReport,
        StudentPurchaseHistory,
        StudentBadges,
        StudentIncreaseScore, 
    },
    data() {
        return {
            student: null,
            studentId: this.$route.params.id,
        };
    },
    created() {
        this.fetchStudentDetails();
    },
    methods: {
        fetchStudentDetails() {
            axios.get(`/v1/students/${this.studentId}`)
                .then(response => {
                    this.student = response.data;
                })
                .catch(error => {
                    console.error('Error fetching student details:', error);
                });
        },
        formatTimeAgo(date) {
            return formatDistanceToNow(new Date(date), { addSuffix: true });
        },
    },
};
</script>
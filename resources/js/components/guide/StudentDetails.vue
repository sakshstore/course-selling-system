
<template>
    <div>
    <StudentBioCard :studentId="studentId" />
    
    <b-tabs>
    <b-tab title="Course List">
    <EnrollCourses :studentId="studentId" />
    </b-tab>
    <b-tab title="Login History" active>
    <StudentLoginHistory :studentId="studentId" />
    </b-tab>
    <b-tab title="Activity Report">
    <StudentActivityReport :studentId="studentId" />
    </b-tab>
    <b-tab title="Purchase History">
    <StudentPurchaseHistory :studentId="studentId" />
    </b-tab>
  
    
    
    

    </b-tabs>
    </div>
    </template>




<script>



import EnrollCourses from '@/components/guide/EnrollCourses.vue';
import StudentLoginHistory from '@/components/guide/StudentLoginHistory.vue';
import StudentActivityReport from '@/components/guide/StudentActivityReport.vue';
import StudentPurchaseHistory from '@/components/guide/StudentPurchaseHistory.vue';
import StudentBadges from '@/components/guide/StudentBadges.vue';
import StudentIncreaseScore from '@/components/guide/StudentIncreaseScore.vue';
import StudentBioCard from '@/components/guide/StudentBioCard.vue';

export default {
    components: {
        EnrollCourses,
        StudentLoginHistory,
        StudentActivityReport,
        StudentPurchaseHistory,
        StudentBadges,
        StudentIncreaseScore, StudentBioCard,
    },
    data() {
        return {
            student: null,
            studentId: this.$route.params.id,
        };
    },
    created() {

    },
    methods: {

    },
};
</script>
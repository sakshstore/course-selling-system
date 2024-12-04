<template>
   <div>
      <div v-if="activityReport.length" class="mt-3">
         <h4>Activity Report</h4>
         <ul class="list-group">
            <li v-for="activity in activityReport" :key="activity.id" class="list-group-item">
               {{ activity.description }} - {{ formatTimeAgo(activity.created_at) }}
            </li>
         </ul>
      </div>
   </div>
</template>

<script>
import apiService from '@/apiService';

import { formatDistanceToNow } from 'date-fns';

export default {
   props: {
      studentId: {
         type: String,
         required: true,
      },
   },
   data() {
      return {
         activityReport: [],
      };
   },
   created() {
      this.fetchActivityReport();
   },
   methods: {
      fetchActivityReport() {
         apiService.getActivityReport(this.studentId)
            .then(response => {
               this.activityReport = response.data;
            })
            .catch(error => {
               console.error('Error fetching activity report:', error);
            });
      },
      formatTimeAgo(date) {
         return formatDistanceToNow(new Date(date), { addSuffix: true });
      }
   }
};
</script>
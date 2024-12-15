<template>
    <div>
        <h4>Leads Report by Tags</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Tag</th>
                    <th>Total Leads</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="report in reports" :key="report.tag">
                    <td>{{ report.tag }}</td>
                    <td>{{ report.total_leads }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';
import apiService from '@/apiService';
export default {
    data() {
        return {
            reports: []
        };
    },
    mounted() {
        this.fetchReport();
    },
    methods: {
        async fetchReport() {

            const response = await apiService.reportByTags();


            this.reports = response.data;
        }
    }
};
</script>